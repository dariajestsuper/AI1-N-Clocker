/* eslint-disable mdx/no-unused-expressions */
/* eslint-disable no-console */
/* eslint-disable prettier/prettier */
const { exec } = require('child_process');
const fs = require('fs');
const { promises: fsp } = require('fs');
const path = require('path');

const pathToService = './src/js/services/ApiClient';
const folders = ['api', 'model'];
const files = ['index.js', 'ApiClient.js'];

const generate = async () => {
    try {
        console.log('Creating temp directory...')
        const folder = await createTempDirectory();
        const path = './' + folder;
        console.log('\x1b[32m', 'OK 👌', '\x1b[0m')
        console.log('Generating files with swagger-codegen...')
        await executeSwaggerCodegenCommand(path);
        console.log('\x1b[32m', 'OK 👌', '\x1b[0m')
        console.log('Removing old client models...')
        await removeGeneratedDirs();
        console.log('\x1b[32m', 'OK 👌', '\x1b[0m')
        console.log('Coping generated files into '+pathToService+'...')
        await copyFromTemp(path);
        console.log('\x1b[32m', 'OK 👌', '\x1b[0m')
        // console.log('Correcting generated model names...')
        // await executeRenameCommand();
        // console.log('\x1b[32m', 'OK 👌', '\x1b[0m')

        fs.rmdirSync(path, { recursive: true });
    } catch (e) {
        console.log('\x1b[31m', `error: ${e.message}`, '\x1b[0m');
        console.log(e)
        return;
    }
};

const removeGeneratedDirs = async function () {
    const items = [...folders,...files];
    let entries = await fsp.readdir(pathToService, { withFileTypes: true });
    for (let entry of entries) {
        if(items.includes(entry.name))
            if(entry.isDirectory())
                fs.rmdirSync(pathToService +'/'+ entry.name, { recursive: true });
            else
                fs.rmSync(pathToService +'/'+ entry.name);
    }
};

const copyFromTemp = async function (pathToTemp) {
    for (folder in folders)
        await copyDir(pathToTemp + '/src/' + folders[folder], pathToService+'/' + folders[folder]);
    for (file in files)
        await fsp.copyFile(pathToTemp + '/src/' + files[file], pathToService+'/'+files[file]);
};

const createTempDirectory = function () {
    return new Promise((resolve, reject) => {
        fs.mkdtemp(`temp-`, (err, folder) => {
            if (err) {
                console.log('\x1b[31m', `error: ${err.message}`, '\x1b[0m');
                return reject();
            }
            return resolve(folder);
        });
    });
};
const executeSwaggerCodegenCommand = function (path) {
    return new Promise((resolve, reject) => {
        exec(
            `swagger-codegen generate --lang javascript -i ${process.env.SWAGGER_URL} -o ${path} --additional-properties usePromises=true,useES6=true -Dio.swagger.parser.util.RemoteUrl.trustAll=true -Dio.swagger.v3.parser.util.RemoteUrl.trustAll=true`,
            (error, stdout, stderr) => {
                console.log(error)
                console.log(stdout)
                console.log(stderr)
                if (error) {
                    console.log('\x1b[31m', `error: ${error.message}`, '\x1b[0m');
                    console.log('Please install swagger-codegen first:');
                    console.log('\x1b[32m', 'brew install swagger-codegen', '\x1b[0m');
                    reject();
                }
                resolve();
            }
        );
    });
};
const executeRenameCommand = function () {
    return new Promise((resolve, reject) => {
        exec(
            `find ./src/js/services/ApiClient -name "*.js" -exec sed -i "" -e "s/ModelObject/Operation/g" "{}" +`,
            (error, stdout, stderr) => {
                if (error) {
                    console.log('\x1b[31m', `error: ${error.message}`, '\x1b[0m');
                    reject();
                }
                if (stderr) {
                    console.log(`stderr: ${stderr}`);
                }
                resolve();
            }
        );
    });
};
async function copyDir(src, dest) {
    await fsp.mkdir(dest, { recursive: true });
    let entries = await fsp.readdir(src, { withFileTypes: true });

    for (let entry of entries) {
        let srcPath = path.join(src, entry.name);
        let destPath = path.join(dest, entry.name);

        entry.isDirectory()
            ? await copyDir(srcPath, destPath)
            : await fsp.copyFile(srcPath, destPath);
    }
}

generate();

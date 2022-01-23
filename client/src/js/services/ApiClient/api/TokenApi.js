/*
 * Hello API Platform
 * No description provided (generated by Swagger Codegen https://github.com/swagger-api/swagger-codegen)
 *
 * OpenAPI spec version: 1.0.0
 *
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen.git
 *
 * Swagger Codegen version: 3.0.32
 *
 * Do not edit the class manually.
 *
 */
import {ApiClient} from "../ApiClient";
import {Credentials} from '../model/Credentials';
import {Token} from '../model/Token';

/**
* Token service.
* @module api/TokenApi
* @version 1.0.0
*/
export class TokenApi {

    /**
    * Constructs a new TokenApi. 
    * @alias module:api/TokenApi
    * @class
    * @param {module:ApiClient} [apiClient] Optional API client implementation to use,
    * default to {@link module:ApiClient#instanc
    e} if unspecified.
    */
    constructor(apiClient) {
        this.apiClient = apiClient || ApiClient.instance;
    }



    /**
     * Get JWT token to login.
     * @param {Object} opts Optional parameters
     * @param {module:model/Credentials} opts.body Generate new JWT Token
     * @return {Promise} a {@link https://www.promisejs.org/|Promise}, with an object containing data of type {@link module:model/Token} and HTTP response
     */
    postCredentialsItemWithHttpInfo(opts) {
      opts = opts || {};
      let postBody = opts['body'];

      let pathParams = {
        
      };
      let queryParams = {
        
      };
      let headerParams = {
        
      };
      let formParams = {
        
      };

      let authNames = ['apiKey'];
      let contentTypes = ['application/json'];
      let accepts = ['application/json'];
      let returnType = Token;

      return this.apiClient.callApi(
        '/authentication_token', 'POST',
        pathParams, queryParams, headerParams, formParams, postBody,
        authNames, contentTypes, accepts, returnType
      );
    }

    /**
     * Get JWT token to login.
     * @param {Object} opts Optional parameters
     * @param {module:model/Credentials} opts.body Generate new JWT Token
     * @return {Promise} a {@link https://www.promisejs.org/|Promise}, with data of type {@link module:model/Token}
     */
    postCredentialsItem(opts) {
      return this.postCredentialsItemWithHttpInfo(opts)
        .then(function(response_and_data) {
          return response_and_data.data;
        });
    }

}
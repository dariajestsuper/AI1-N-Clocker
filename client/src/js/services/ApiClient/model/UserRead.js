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
import {ApiClient} from '../ApiClient';

/**
 * The UserRead model module.
 * @module model/UserRead
 * @version 1.0.0
 */
export class UserRead {
  /**
   * Constructs a new <code>UserRead</code>.
   * @alias module:model/UserRead
   * @class
   */
  constructor() {
  }

  /**
   * Constructs a <code>UserRead</code> from a plain JavaScript object, optionally creating a new instance.
   * Copies all relevant properties from <code>data</code> to <code>obj</code> if supplied or a new instance if not.
   * @param {Object} data The plain JavaScript object bearing properties of interest.
   * @param {module:model/UserRead} obj Optional instance to populate.
   * @return {module:model/UserRead} The populated <code>UserRead</code> instance.
   */
  static constructFromObject(data, obj) {
    if (data) {
      obj = obj || new UserRead();
      if (data.hasOwnProperty('email'))
        obj.email = ApiClient.convertToType(data['email'], 'String');
      if (data.hasOwnProperty('roles'))
        obj.roles = ApiClient.convertToType(data['roles'], ['String']);
    }
    return obj;
  }
}

/**
 * @member {String} email
 */
UserRead.prototype.email = undefined;

/**
 * @member {Array.<String>} roles
 */
UserRead.prototype.roles = undefined;


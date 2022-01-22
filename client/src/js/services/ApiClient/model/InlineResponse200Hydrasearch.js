/**
 * Hello API Platform
 * No description provided (generated by Swagger Codegen https://github.com/swagger-api/swagger-codegen)
 *
 * OpenAPI spec version: 1.0.0
 * 
 *
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen.git
 * Do not edit the class manually.
 *
 */

import ApiClient from '../ApiClient';
import InlineResponse200HydrasearchHydramapping from './InlineResponse200HydrasearchHydramapping';

/**
* The InlineResponse200Hydrasearch model module.
* @module model/InlineResponse200Hydrasearch
* @version 1.0.0
*/
export default class InlineResponse200Hydrasearch {
    /**
    * Constructs a new <code>InlineResponse200Hydrasearch</code>.
    * @alias module:model/InlineResponse200Hydrasearch
    * @class
    */

    constructor() {
        
        
        
    }

    /**
    * Constructs a <code>InlineResponse200Hydrasearch</code> from a plain JavaScript object, optionally creating a new instance.
    * Copies all relevant properties from <code>data</code> to <code>obj</code> if supplied or a new instance if not.
    * @param {Object} data The plain JavaScript object bearing properties of interest.
    * @param {module:model/InlineResponse200Hydrasearch} obj Optional instance to populate.
    * @return {module:model/InlineResponse200Hydrasearch} The populated <code>InlineResponse200Hydrasearch</code> instance.
    */
    static constructFromObject(data, obj) {
        if (data) {
            obj = obj || new InlineResponse200Hydrasearch();
                        
            
            if (data.hasOwnProperty('@type')) {
                obj['@type'] = ApiClient.convertToType(data['@type'], 'String');
            }
            if (data.hasOwnProperty('hydra:template')) {
                obj['hydra:template'] = ApiClient.convertToType(data['hydra:template'], 'String');
            }
            if (data.hasOwnProperty('hydra:variableRepresentation')) {
                obj['hydra:variableRepresentation'] = ApiClient.convertToType(data['hydra:variableRepresentation'], 'String');
            }
            if (data.hasOwnProperty('hydra:mapping')) {
                obj['hydra:mapping'] = ApiClient.convertToType(data['hydra:mapping'], [InlineResponse200HydrasearchHydramapping]);
            }
        }
        return obj;
    }

    /**
    * @member {String} @type
    */
    '@type' = undefined;
    /**
    * @member {String} hydra:template
    */
    'hydra:template' = undefined;
    /**
    * @member {String} hydra:variableRepresentation
    */
    'hydra:variableRepresentation' = undefined;
    /**
    * @member {Array.<module:model/InlineResponse200HydrasearchHydramapping>} hydra:mapping
    */
    'hydra:mapping' = undefined;




}

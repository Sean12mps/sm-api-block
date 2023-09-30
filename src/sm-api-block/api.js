import apiFetch from '@wordpress/api-fetch';

import { addQueryArgs } from '@wordpress/url';

/**
 * Fetch table resource.
 *
 * @param {string} endpointURL
 * @param {array} columns
 * @param {function} callback
 *
 * @return {void}
 */
const fetchTableResource = ( endpointURL, columns, callback ) => {

  // Build query params.
  const queryParams = columns ? {
    columns: columns,
  } : {};

  // Build path.
  const path = addQueryArgs( endpointURL, queryParams );

  // Fetch data from API.
  apiFetch( { path: path } )
    .then( ( response ) => {
      // Set data table.
      const responseData = response.data;

      // Run callback function.
      callback( responseData );
    } );
}

export default fetchTableResource;

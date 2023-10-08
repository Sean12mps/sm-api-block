import ApiTable from './ApiTable';

import fetchTableResource from './api';

window.addEventListener('load', () => {

  // Get parent element name.
  const parentClass = smApiBlock.parentClass;

  // Get base URL from WP settings.
  const endpointURL = smApiBlock.endpointURL;

  // Get all element with block class.
  const apiTables = document.querySelectorAll(`.${parentClass}`);

  // Loop and init.
  apiTables.forEach((apiTable) => {

    // Get data-columns attribute.
    const dataColumns = apiTable.getAttribute('data-columns');

    // Explode data-columns attribute.
    const activeColumns = dataColumns.split(',');

    // Fetch data from API.
    fetchTableResource( endpointURL, activeColumns, ( responseData ) => {

      ReactDOM.render(
        <ApiTable
          tableTitle={responseData.title}
          tableData={responseData.filtered_data}
        />,
        apiTable
      );
    });
  });
});

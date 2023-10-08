/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';

import { Panel, PanelBody, ToggleControl } from '@wordpress/components';

import { useEffect } from '@wordpress/element';

import ApiTable from './ApiTable';

import fetchTableResource from './api';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @TODO: Find a way to get base URL from WP settings.
 * @TODO: Add setting to allow hiding table header.
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {

  // Get base URL from WP settings.
  const endpointURL = smApiBlock.endpointURL;

  // Setup change handlers.
  const toggleActiveColumn = ( value ) => {

    // Setup new active columns.
    let newActiveColumns = attributes.activeColumns;

    // If value is in active columns, remove it.
    if ( attributes.activeColumns.includes( value ) ) {
      newActiveColumns = newActiveColumns.filter( ( column ) => {
        return column !== value;
      } );
    } else {
      newActiveColumns.push( value );
    }

    // Sort active columns based on default columns.
    newActiveColumns.sort( ( a, b ) => {
      return attributes.defaultColumns.indexOf( a ) - attributes.defaultColumns.indexOf( b );
    } );

    // Fetch data from API.
    fetchTableResource( endpointURL, newActiveColumns, ( responseData ) => {

      setAttributes({
        tableTitle: responseData.title,
        dataTable: responseData.filtered_data,
        hasLoaded: true,
        activeColumns: newActiveColumns
      });
    });
  }

  // Fetch data from API.
  useEffect( () => {

    const hasActiveColumns = attributes.activeColumns.length > 0;

    const columns = hasActiveColumns ? attributes.activeColumns : null;

    // Fetch data from API.
    fetchTableResource( endpointURL, columns, ( responseData ) => {

      setAttributes({
        defaultColumns: responseData.data.headers,
        activeColumns:
          hasActiveColumns
          ?
          attributes.activeColumns
          :
          responseData.data.headers,
        tableTitle: responseData.title,
        dataTable:
          hasActiveColumns
          ?
          responseData.filtered_data
          :
          responseData.data,
        hasLoaded: true
      });
    } );
  }, [ endpointURL ] );

  // Toggle column settings.
  const ColumnSettings = () => {

    let columns = attributes.defaultColumns.map( ( header ) => {

        // Check if column is active.
        const checked = attributes.activeColumns.includes( header );

        // Return toggle control for each column.
        return (
          <ToggleControl
            __nextHasNoMarginBottom
            label={ header }
            checked={ checked }
            onChange={ () => { toggleActiveColumn( header ) } }
          />
        )
    } );

    return columns;
  };

  // Return block edit.
	return (
		<div { ...useBlockProps() }>

      <InspectorControls>
        <Panel>
          <PanelBody
            title={ __( 'Column Settings', 'sm-api-block' ) }
            icon="admin-plugins"
          >
            { attributes.hasLoaded ? ColumnSettings() : __( 'Loading...', 'sm-api-block' ) }
          </PanelBody>
        </Panel>
      </InspectorControls>

      {
        attributes.hasLoaded
        ?
        <ApiTable
          tableTitle={ attributes.tableTitle }
          tableData={ attributes.dataTable }
        />
        :
        __( 'Loading...', 'sm-api-block' )
      }
		</div>
	);
}

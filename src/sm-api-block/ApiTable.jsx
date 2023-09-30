/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

import react from 'react';

class ApiTable extends react.Component {

    // Set initial state.
    constructor( props ) {
        super( props );

        // Set initial state.
        this.state = {
            tableTitle: '',
            tableData: {},
        };
    }

    // Render component.
    render() {

        // Get table title.
        const tableTitle = this.props.tableTitle ? this.props.tableTitle : this.state.tableTitle;

        // Get table data.
        const tableData = this.props.tableData ? this.props.tableData : this.state.tableData;

        // Print data.
        return (
            <div className="sm-api-table">

                {
                    tableTitle
                    ?
                    <h2>{ tableTitle }</h2>
                    :
                    ''
                }

                {
                    tableData?.headers && tableData?.rows
                    ?
                    <table>
                        <thead>
                            <tr>
                                { tableData.headers.map( ( header, index ) => (
                                    <th key={ index }>{ header }</th>
                                ) ) }
                            </tr>
                        </thead>
                        <tbody>
                            { Object.keys( tableData.rows ).map( ( row, index ) => (
                                <tr key={ index }>
                                    { Object.keys( tableData.rows[ row ] ).map( ( column, index ) => (
                                        <td key={ index }>{ tableData.rows[ row ][ column ] }</td>
                                    ) ) }
                                </tr>
                            ) ) }
                        </tbody>
                    </table>
                    :
                    <p>{ __( 'Loading...', 'sm-api-block' ) }</p>
                }
            </div>
        );
    }
}

export default ApiTable;

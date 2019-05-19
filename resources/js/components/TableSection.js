import React from "react";
import { Row, Table } from "react-bootstrap";
import TableRow from "./TableRow";

/*
 * Displays the Bootstrap Row for the Table.
 * Props:
 * transactions, array, Contains data for each form row
 * errors: string, Error message to be shown instead of the table
 */
const TableSection = props => {
    const rows = props.transactions.map((item, index) => {
        return <TableRow {...item} key={index} />;
    });
    return (
        <Row className="mt2">
            {props.errors ? (
                <p className="cR">{props.errors}</p>
            ) : (
                <Table striped bordered hover>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>DateTime</th>
                            <th>Customer Number</th>
                            <th>First Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Recommend</th>
                            <th>Status Message</th>
                        </tr>
                    </thead>
                    <tbody>{rows}</tbody>
                </Table>
            )}
        </Row>
    );
};

export default TableSection;

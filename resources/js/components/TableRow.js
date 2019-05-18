import React from "react";

const TableRow = props => {
    return (
        <tr>
            <td>{props.trans_type}</td>
            <td>{props.dateTime}</td>
            <td>{props.cust_num}</td>
            <td>{props.cust_fname}</td>
            <td>
                {props.useEmail ? (
                    <strong>{props.cust_email}</strong>
                ) : (
                    props.cust_email
                )}
            </td>
            <td>
                {props.usePhone ? (
                    <strong>{props.cust_phone}</strong>
                ) : (
                    props.cust_phone
                )}
            </td>
            <td>
                {props.recommend ? (
                    <i className="fa fa-check" />
                ) : (
                    <i className="fa fa-times" />
                )}
            </td>
            <td>{props.message}</td>
        </tr>
    );
};

export default TableRow;

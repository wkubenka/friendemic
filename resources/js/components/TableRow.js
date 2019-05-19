import React from "react";

/*
 * Displays a single transaction row in a table.
 * Props:
 * trans_type: string, type of transaction
 * dateTime: string, Date of the transaction
 * cust_num: string, Customer Number
 * cust_fname: string, Customer First Name
 * useEmail: boolean, Indicates the email address should be used to contact the customer
 * cust_email: string, Customer Email Address
 * usePhone: boolean, Indicates the phone number should be used to contact the customer
 * cust_phone: string, Customer Phone Number
 * recommend: boolean, Should the customer be contacted?
 * message: string, Status message about the recommendation
 */
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

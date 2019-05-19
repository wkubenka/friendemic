import React from "react";
import ReactDOM from "react-dom";
import TableSection from "../components/TableSection";

const transactions = [
    {
        cust_email: "bob1@gmail.com",
        cust_fname: "Bob",
        cust_num: "10012",
        cust_phone: "123-123-1234",
        dateTime: "2018-03-01 13:00:00",
        message: "older record exists",
        recommend: false,
        trans_type: "sales",
        useEmail: false,
        usePhone: true
    }
];

it("Renders without crashing", () => {
    const div = document.createElement("div");
    ReactDOM.render(<TableSection transactions={transactions} />, div);
});

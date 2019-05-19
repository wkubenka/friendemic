import React, { useState } from "react";
import { Container } from "react-bootstrap";
import FormSection from "./FormSection";
import TableSection from "./TableSection";

/*
 * Displays the Bootstrap Row for the form.
 * State:
 * uploading, boolean, Disables the button if the form is currently submitting
 * transactions: array, Actions to be taken when the form is submitted.
 */

const App = () => {
    const [submitting, setSubmitting] = useState(false);
    const [transactions, setTransactions] = useState([]);
    const [errors, setErrors] = useState("");

    const handleSubmit = e => {
        e.preventDefault();
        setSubmitting(true);

        const file = e.target.file.files[0];
        const formData = new FormData();
        formData.append("file", file);

        fetch("/api/upload", {
            method: "POST",
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                setSubmitting(false);
                setTransactions(data);
                setErrors("");
            })
            .catch(error => {
                setSubmitting(false);
                setErrors("Error processing CSV file.");
            });
    };

    return (
        <Container>
            <FormSection submitting={submitting} handleSubmit={handleSubmit} />
            <TableSection errors={errors} transactions={transactions} />
        </Container>
    );
};

export default App;

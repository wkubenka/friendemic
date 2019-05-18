import React, { useState } from "react";
import ReactDOM from "react-dom";
import TableRow from "./tablerow";
import { Button, Container, Form, Row, Table } from "react-bootstrap";

const App = () => {
    const [uploading, setUploading] = useState(false);
    const [customers, setCustomers] = useState([]);
    const [errors, setErrors] = useState("");

    const handleSubmit = e => {
        e.preventDefault();
        setUploading(true);

        const file = e.target.file.files[0];
        const formData = new FormData();
        formData.append("file", file);

        fetch("/api/upload", {
            method: "POST",
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                setUploading(false);
                setCustomers(data);
                setErrors("");
            })
            .catch(error => {
                setUploading(false);
                setErrors("Error processing CSV file.");
            });
    };
    const rows = customers.map((item, index) => {
        return <TableRow {...item} key={index} />;
    });
    return (
        <Container>
            <Row>
                <Form
                    className="ml-auto"
                    onSubmit={e => handleSubmit(e)}
                    inline="true"
                >
                    <Form.Group controlid="file">
                        <Form.Label>CSV File to Upload</Form.Label>
                        <Form.Control
                            name="file"
                            type="file"
                            accept=".csv"
                            id="file"
                        />
                    </Form.Group>
                    <Button
                        variant={
                            uploading ? "outline-secondary" : "outline-primary"
                        }
                        disabled={uploading}
                        type="submit"
                    >
                        Submit
                    </Button>
                </Form>
            </Row>
            <Row className="mt2">
                {errors ? (
                    <p className="cR">{errors}</p>
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
        </Container>
    );
};

ReactDOM.render(<App />, document.getElementById("app"));

import React from "react";
import { Button, Form, Row } from "react-bootstrap";

/*
 * Displays the Bootstrap Row for the form.
 * Props:
 * submitting, boolean, Disables the button if the form is currently submitting
 * handleSubmit: function(event), Actions to be taken when the form is submitted.
 */
const FormSection = props => {
    return (
        <Row>
            <Form
                className="ml-auto"
                onSubmit={e => props.handleSubmit(e)}
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
                        props.submitting
                            ? "outline-secondary"
                            : "outline-primary"
                    }
                    disabled={props.submitting}
                    type="submit"
                >
                    Submit
                </Button>
            </Form>
        </Row>
    );
};

export default FormSection;

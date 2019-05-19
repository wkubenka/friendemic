import React from "react";
import ReactDOM from "react-dom";
import FormSection from "../components/FormSection";

it("Renders without crashing", () => {
    const div = document.createElement("div");
    ReactDOM.render(<FormSection />, div);
});

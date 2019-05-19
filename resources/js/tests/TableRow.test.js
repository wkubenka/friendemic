import React from "react";
import ReactDOM from "react-dom";
import TableRow from "../components/TableRow";

it("Renders without crashing", () => {
    const tbody = document.createElement("tbody");
    ReactDOM.render(<TableRow />, tbody);
});

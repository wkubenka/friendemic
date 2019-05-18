import React, { useState } from "react";

const Form = props => {
    const [uploading, setUploading] = useState(false);
    // const [processedFile, setProcessedFile] = useState([]);

    const handleSubmit = e => {
        e.preventDefault();
        setUploading(true);
        const file = e.target.file.value;
        console.log(file);

        const formData = new FormData();
        formData.append("file", file);

        fetch("/api/upload", {
            method: "POST",
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                setUploading(false);
                setProcessedFile(data);
            });
    };

    return (
        <form onSubmit={e => handleSubmit(e)}>
            <input name="file" type="file" />
            <input type="submit" disabled={uploading} />
        </form>
    );
};

export default Form;

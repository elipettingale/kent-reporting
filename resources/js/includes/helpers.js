export function forEachField(section, callback) {
    section.fields.forEach((field) => {
        if (field.component === "KTable") {
            field.rows.forEach((row) => {
                field.rowFields.forEach((rowField) => {
                    callback(
                        `${section.key}_${field.key}_${row.key}_${rowField.key}`,
                        rowField
                    );
                });
            });
        } else if (field.key && !field.disabled) {
            callback(`${section.key}_${field.key}`, field);
        }
    });
}

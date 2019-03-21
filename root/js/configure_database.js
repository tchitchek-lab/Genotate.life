function database_reset() {

    if (!confirm('Are you sure to reset the Genotate database?')) {
        return;
    }

    const db_name = document.getElementById("database").value;
    if (db_name !== "") {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/root/includes/manage_database.php?action=reset&db_name=' + db_name);
        xhr.addEventListener('readystatechange', function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                alert("The genotate database has been reset!");
            }
        });
        xhr.send(null);
    }
}

// function database_create() {
//     if (confirm('Are you sure to reset the Genotate database?'))
//         return;
//
//     const db_name = document.getElementById("database").value;
//     if (db_name !== "") {
//         const xhr = new XMLHttpRequest();
//         xhr.open('GET', '/root/includes/manage_database.php?action=create&db_name=' + db_name);
//         xhr.addEventListener('readystatechange', function () {
//             if (xhr.readyState === XMLHttpRequest.DONE) {
//                 alert("The genotate database has been create!");
//             }
//         });
//         xhr.send(null);
//     }
//
// }

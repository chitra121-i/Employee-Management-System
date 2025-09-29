function searchByName() {
    let input = document.getElementById("searchInput");
    let filter = input.value.toUpperCase();
    let table = document.getElementById("dataTable");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) { // Skip header
        let td = tr[i].getElementsByTagName("td")[1]; // Name column
        if (td) {
            let txtValue = td.textContent || td.innerText;
            tr[i].style.display = txtValue.toUpperCase().includes(filter) ? "" : "none";
        }
    }
}

    function validateForm() {
        const title = document.getElementById('title').value.trim();
        const message = document.getElementById('message').value.trim();
        if (title === "" || message === "") {
            alert("Both title and message are required.");
            return false;
        }
        return true;
    }
function editNotice(id, title, message) {
    document.getElementById('notice_id').value = id;
    document.getElementById('title').value = title;
    document.getElementById('message').value = message;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function clearForm() {
    document.getElementById('notice_id').value = '';
}
function editCalendar(id, desc, start, end, classes) {
    document.getElementById('calendar_id').value = id;
    document.getElementById('description').value = desc;
    document.getElementById('start_date').value = start;
    document.getElementById('end_date').value = end;
    document.getElementById('classes').value = classes;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function clearForm() {
    document.getElementById('calendar_id').value = '';
}

// Live search
document.getElementById('searchInput').addEventListener('keyup', function () {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll("#allocationTable tr");
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(value) ? '' : 'none';
    });
});
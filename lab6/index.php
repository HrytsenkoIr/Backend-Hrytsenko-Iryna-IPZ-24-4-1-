<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>App</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f8;
            margin: 0;
            padding: 20px;
        }

        h2 {
            margin-bottom: 10px;
        }

        .block {
            background: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        input {
            display: block;
            width: 100%;
            padding: 8px;
            margin-bottom: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 6px 10px;
            margin-top: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background: #3498db;
            color: white;
        }

        button:hover {
            background: #2980b9;
        }

        .danger {
            background: #e74c3c;
        }

        .danger:hover {
            background: #c0392b;
        }

        .edit {
            background: #f39c12;
        }

        .edit:hover {
            background: #d68910;
        }

        ul {
            padding-left: 15px;
        }

        li {
            margin: 6px 0;
        }

        .success { color: green; }
        .error { color: red; }
    </style>

</head>
<body>

<div class="block">
    <h2>Register</h2>
    <input id="nameInput" placeholder="Name">
    <input id="emailInput" placeholder="Email">
    <input id="passwordInput" type="password" placeholder="Password">
    <button onclick="register()">Register</button>
    <div id="regMsg"></div>
</div>

<div class="block">
    <h2>Login</h2>
    <input id="loginEmail" placeholder="Email">
    <input id="loginPass" type="password" placeholder="Password">
    <button onclick="login()">Login</button>
    <div id="loginMsg"></div>
</div>

<div class="block">
    <h2>Users</h2>
    <button onclick="loadUsers()">Load Users</button>
    <ul id="users"></ul>
</div>

<div class="block">
    <h2>Notes</h2>
    <input id="titleInput" placeholder="Title">
    <input id="contentInput" placeholder="Content">
    <button onclick="addNote()">Add</button>
    <div id="noteMsg"></div>

    <ul id="notes"></ul>
</div>

<script>
    function register() {
        const name = document.getElementById("nameInput").value;
        const email = document.getElementById("emailInput").value;
        const password = document.getElementById("passwordInput").value;
        const msg = document.getElementById("regMsg");

        msg.innerHTML = "";

        if (!name || !email || !password) {
            msg.innerHTML = "<span class='error'>Fill all fields</span>";
            return;
        }

        fetch("register.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ name, email, password })
        })
            .then(r => r.json())
            .then(d => {
                msg.innerHTML = d.error
                    ? `<span class='error'>${d.error}</span>`
                    : "<span class='success'>Registered</span>";
            });
    }

    function login() {
        const email = document.getElementById("loginEmail").value;
        const password = document.getElementById("loginPass").value;
        const msg = document.getElementById("loginMsg");

        if (!email || !password) {
            msg.innerHTML = "<span class='error'>Fill all fields</span>";
            return;
        }

        fetch("login.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ email, password })
        })
            .then(r => r.json())
            .then(d => {
                msg.innerHTML = d.error
                    ? `<span class='error'>${d.error}</span>`
                    : "<span class='success'>Logged in</span>";
            });
    }

    function loadUsers() {
        fetch("get_users.php")
            .then(r => r.json())
            .then(data => {
                const users = document.getElementById("users");
                users.innerHTML = "";

                data.forEach(u => {
                    users.innerHTML += `
                <li>
                    ${u.name} (${u.email})
                    <button class="edit" onclick="editUser(${u.id}, '${u.name}', '${u.email}')">Edit</button>
                    <button class="danger" onclick="deleteUser(${u.id})">X</button>
                </li>
            `;
                });
            });
    }

    function editUser(id, oldName, oldEmail) {
        const name = prompt("New name:", oldName);
        const email = prompt("New email:", oldEmail);

        if (name && email) {
            fetch("update_user.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id, name, email })
            })
                .then(() => loadUsers());
        }
    }

    function deleteUser(id) {
        fetch("delete_user.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id })
        })
            .then(() => loadUsers());
    }

    function addNote() {
        const title = document.getElementById("titleInput").value;
        const content = document.getElementById("contentInput").value;
        const msg = document.getElementById("noteMsg");

        msg.innerHTML = "";

        if (!title || !content) {
            msg.innerHTML = "<span class='error'>Fill all fields</span>";
            return;
        }

        fetch("notes.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ title, content })
        })
            .then(r => r.json())
            .then(d => {
                if (d.error) {
                    msg.innerHTML = `<span class='error'>${d.error}</span>`;
                } else {
                    msg.innerHTML = "<span class='success'>Note added</span>";
                    loadNotes();
                    document.getElementById("titleInput").value = "";
                    document.getElementById("contentInput").value = "";
                }
            });
    }

    function loadNotes() {
        fetch("notes.php")
            .then(r => r.json())
            .then(data => {
                const notes = document.getElementById("notes");
                notes.innerHTML = "";

                data.forEach(n => {
                    notes.innerHTML += `
                <li>
                    <b>${n.title}</b>: ${n.content}
                    <button class="edit" onclick="editNote(${n.id}, '${n.title}', '${n.content}')">Edit</button>
                    <button class="danger" onclick="deleteNote(${n.id})">X</button>
                </li>
            `;
                });
            });
    }

    function editNote(id, oldTitle, oldContent) {
        const title = prompt("New title:", oldTitle);
        const content = prompt("New content:", oldContent);

        if (title && content) {
            fetch("notes.php", {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id, title, content })
            })
                .then(() => loadNotes());
        }
    }

    function deleteNote(id) {
        fetch("notes.php", {
            method: "DELETE",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id })
        })
            .then(() => loadNotes());
    }

    loadNotes();
</script>

</body>
</html>
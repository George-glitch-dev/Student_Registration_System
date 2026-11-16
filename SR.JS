const studentStorageKey = "studentRegistrationEntries";

const sampleStudents = [
    { name: "Amina Hassan", age: 21, course: "Web Development" },
    { name: "Brian Otieno", age: 24, course: "Data Science" },
    { name: "Chloe Mwangi", age: 29, course: "Graphic Design" },
    { name: "David Kimani", age: 23, course: "Cybersecurity" },
    { name: "Fatima Noor", age: 20, course: "Business Management" }
];

function randomStudentAge() {
    return Math.floor(Math.random() * 61) + 20;
}

function getRegisteredStudents() {
    try {
        const savedStudents = localStorage.getItem(studentStorageKey);
        if (savedStudents === null) {
            localStorage.setItem(studentStorageKey, JSON.stringify(sampleStudents));
            return [...sampleStudents];
        }
        const students = JSON.parse(savedStudents);
        if (!Array.isArray(students)) return [];

        let needsSave = false;
        const migratedStudents = students.map((student) => {
            const migratedStudent = { ...student };
            if (!Number.isInteger(Number(migratedStudent.age)) || Number(migratedStudent.age) < 20 || Number(migratedStudent.age) > 80) {
                migratedStudent.age = randomStudentAge();
                needsSave = true;
            } else {
                migratedStudent.age = Number(migratedStudent.age);
            }
            if ("email" in migratedStudent) {
                delete migratedStudent.email;
                needsSave = true;
            }
            return migratedStudent;
        });
        if (needsSave) localStorage.setItem(studentStorageKey, JSON.stringify(migratedStudents));
        return migratedStudents;
    } catch {
        return [];
    }
}

const registeredStudentsList = document.getElementById("registeredStudents");

if (registeredStudentsList) {
    const students = getRegisteredStudents();
    students.forEach((student) => {
        const row = document.createElement("div");
        row.className = "student-row";

        [student.name, student.age, student.course].forEach((value) => {
            const cell = document.createElement("span");
            cell.textContent = value;
            row.appendChild(cell);
        });

        registeredStudentsList.appendChild(row);
    });

    const lastRegisteredStudentName = localStorage.getItem("lastRegisteredStudentName");
    if (lastRegisteredStudentName) {
        const message = document.createElement("p");
        message.className = "registration-success";
        message.setAttribute("role", "status");
        message.textContent = `${lastRegisteredStudentName} was registered successfully.`;
        registeredStudentsList.before(message);
        localStorage.removeItem("lastRegisteredStudentName");
    }
}

const editableStudentsList = document.getElementById("editableStudents");

if (editableStudentsList) {
    const editMessage = document.getElementById("editMessage");

    function renderEditableStudents() {
        editableStudentsList.replaceChildren();
        const students = getRegisteredStudents();

        if (students.length === 0) {
            editableStudentsList.textContent = "There are no registered students to edit.";
            return;
        }

        students.forEach((student, index) => {
            const form = document.createElement("form");
            form.className = "student-edit-row";
            form.dataset.index = index;

            [
                { label: "Name", key: "name", type: "text" },
                { label: "Age", key: "age", type: "number", min: "20", max: "80" },
                { label: "Course", key: "course", type: "text" }
            ].forEach(({ label, key, type, min, max }) => {
                const field = document.createElement("label");
                field.textContent = label;
                const input = document.createElement("input");
                input.type = type;
                input.name = key;
                input.value = student[key] || "";
                if (min) input.min = min;
                if (max) input.max = max;
                input.required = true;
                field.appendChild(input);
                form.appendChild(field);
            });

            const actions = document.createElement("div");
            actions.className = "student-actions";
            const saveButton = document.createElement("button");
            saveButton.type = "submit";
            saveButton.textContent = "Update";
            const removeButton = document.createElement("button");
            removeButton.type = "button";
            removeButton.className = "remove-student";
            removeButton.dataset.index = index;
            removeButton.textContent = "Remove";
            actions.append(saveButton, removeButton);
            form.appendChild(actions);
            editableStudentsList.appendChild(form);
        });
    }

    editableStudentsList.addEventListener("submit", (event) => {
        if (!event.target.matches(".student-edit-row")) return;
        event.preventDefault();
        const students = getRegisteredStudents();
        const index = Number(event.target.dataset.index);
        const fields = new FormData(event.target);
        students[index] = {
            name: fields.get("name").trim(),
            age: Number(fields.get("age")),
            course: fields.get("course").trim()
        };
        localStorage.setItem(studentStorageKey, JSON.stringify(students));
        editMessage.textContent = "Student details updated. The Students page now shows the changes.";
        renderEditableStudents();
    });

    editableStudentsList.addEventListener("click", (event) => {
        if (!event.target.matches(".remove-student")) return;
        const students = getRegisteredStudents();
        const index = Number(event.target.dataset.index);
        const removedStudent = students.splice(index, 1)[0];
        localStorage.setItem(studentStorageKey, JSON.stringify(students));
        editMessage.textContent = `${removedStudent.name} was removed.`;
        renderEditableStudents();
    });

    renderEditableStudents();
}

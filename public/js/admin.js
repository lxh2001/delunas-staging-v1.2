function toggleTables() {
  const dropdown = document.getElementById("appointmentListDropdown");
  const clientTable = document.getElementById("clientAppointments");
  const doctorTable = document.getElementById("doctorAppointments");

  const selectedOption = dropdown.value;

  if (selectedOption === "client") {
    clientTable.style.display = "table";
    doctorTable.style.display = "none";
  } else if (selectedOption === "doctor") {
    clientTable.style.display = "none";
    doctorTable.style.display = "table";
  }
}

function toggleSchedule(type) {
  var singleDiv = document.getElementById("singleScheduleDiv");
  var recurringDiv = document.getElementById("recurringScheduleDiv");

  if (type === 'single') {
      singleDiv.style.display = "block";
      recurringDiv.style.display = "none";
  } else if (type === 'recurring') {
      singleDiv.style.display = "none";
      recurringDiv.style.display = "block";
  }
}

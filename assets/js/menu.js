let rol = $("#rol").val()

if (rol ==="Administrador") {
} else {
	if (rol === "Empleado") {
		$("#buttonUsers").hide()
		$("#buttonStatus").hide()
		$("#buttonRols").hide()
		$("#buttonTypeStatus").hide()
	} else {
		if (rol === "Cliente") {
		$("#buttonUsers").hide()
		$("#buttonStatus").hide()
		$("#buttonRols").hide()
		$("#buttonTypeStatus").hide()
		$("#buttonCategories").hide()
		$("#buttonAddMovie").hide()
		$("#buttonEditMovie").hide()
		$("#buttonStatusMovie").hide()
		}
	}
}
const submit_btn = document.querySelector("#submit");
const data_table = document.querySelector("#data");
const user_select = document.querySelector("#user");

submit_btn.onclick = function (e) {
	e.preventDefault();
	data_table.style.display = "block";

	const user_id = user_select.value;

	if (user_id != "") {
		$.get("data.php", { user: user_id })
			.always(function () {
				if (data_table.children[1].children[1] != undefined) {
					for (let i = 1; i <= 12; i++) {
						const tr_to_remove = data_table.children[1].children[1];
						tr_to_remove.remove();
					}
				}
			})
			.done(function (response) {
				data_table.children[0].style.color = "#000";
				data_table.children[0].textContent =
					"Transakcje dla " +
					user_select.options[user_select.selectedIndex].text;
				$.each(response.balances_associative, function (key, value) {
					const tr = document.createElement("tr");
					const td_month = document.createElement("td");
					const td_balance = document.createElement("td");
					td_month.textContent = key;
					td_balance.textContent = value;
					data_table.children[1].appendChild(tr);
					tr.append(td_month, td_balance);
				});
			})
			.fail(function (error) {
				alert("Błąd!");
				data_table.children[0].style.color = "#f00";
				data_table.children[0].textContent = "Błąd: " + error.statusText;
			});
	}
};

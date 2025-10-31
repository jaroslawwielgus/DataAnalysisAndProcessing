const submit_btn = document.querySelector("#submit");
const data_table = document.querySelector("#data");
const user_select = document.querySelector("#user");

submit_btn.onclick = function (e) {
	e.preventDefault();
	data_table.style.display = "block";

	// TODO: implement
	const user_id = user_select.value;
	// $.ajax({
	// 	type: "GET",
	// 	url: "data.php",
	// 	dataType: "json",
	// 	data: {
	// 		user: user_id,
	// 	},
	// 	success: function (data) {
	// 		alert(data.balances_associative.Luty);
	// 	},
	// });
	$.get("data.php", { user: user_id }, function (response) {
		alert(response.balances_associative.Luty);
		if (data_table.children[1].children[1] != undefined) {
			for (let i = 1; i <= 12; i++) {
				const tr_to_remove = data_table.children[1].children[1];
				tr_to_remove.remove();
			}
		}
		$.each(response.balances_associative, function (key, value) {
			// console.log(key + " - " + value);
			const tr = document.createElement("tr");
			const td_month = document.createElement("td");
			const td_balance = document.createElement("td");
			td_month.textContent = key;
			td_balance.textContent = value;
			data_table.children[1].appendChild(tr);
			tr.append(td_month, td_balance);
		});
	});
};

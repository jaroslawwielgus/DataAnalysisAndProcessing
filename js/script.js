const submit_btn = document.querySelector("#submit");
const data_table = document.querySelector("#data");
const user_select = document.querySelector("#user");

// for (const child of user_select.children) {
// 	child.onmouseover = function (e) {
// 		e.preventDefault();
// 		child.style.background = "#0a7501";
// 	};
// }

// user_select.children[0].onmouseover = function () {
// 	user_select.children[0].style.background = "#0a7501";
// };

// user_select.children[1].onmouseover = function () {
// 	user_select.children[1].style.background = "#0a7501";
// };

// user_select.children[2].onmouseover = function () {
// 	user_select.children[2].style.background = "#0a7501";
// };

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
		// alert(response.balances_associative.Luty);
		data_table.children[0].textContent =
			"Transakcje dla " + user_select.options[user_select.selectedIndex].text;
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

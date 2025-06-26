let invoice_title = "";
let invoiceItems = [];
let analyzed = [];

window.onload = () => {
	let addbtn = document.querySelector('#addbtn');
	let invTitle = document.querySelector('#invTitle');
	let navlinks = document.querySelectorAll('.navlinks');

	if(addbtn != undefined){
		addbtn.addEventListener("click", () => {
			const itemInput = document.getElementById("inv_item");
			const amountInput = document.getElementById("inv_amt");

			const itemName = itemInput.value.trim();
			const itemAmount = amountInput.value;

			let keepOn = itemName != "";

			if (itemAmount.includes("/")) {
				let nums = itemAmount.split("/");
				keepOn = !isNaN(Number(nums[0])) && !isNaN(Number(nums[1]));
			} else {
				keepOn = !isNaN(Number(itemAmount));
			}

			if (keepOn) {
				invoiceItems.push({ invoice_item: itemName, amount: itemAmount });
				itemInput.value = "";
				amountInput.value = "";
				renderItems();
			} else {
				if(itemName == ""){
					alert("Please enter valid item name.");
				} else {
					alert("Please enter a valid amount.");
				}
			}
		});
	}

	if(invTitle != undefined){
		invTitle.addEventListener('input',(e) => {
			invoice_title = e.target.value;
			titleShow.innerHTML = invoice_title;
		});
	}

	// handle startups
	let copyitems = document.querySelectorAll('[data-copyme]');

	copyitems.forEach(cop => {
		let tocopy = document.querySelector(cop.dataset.copyme);

		if(tocopy != undefined){
			cop.innerHTML = tocopy.innerHTML;
		}
	})

	// setup navbar
	if(navlinks.length > 0){
		navlinks.forEach(curnav => {
			let lnks = curnav.querySelectorAll('a');

			lnks.forEach(el => {
				let mine = getcurfile(el.href);
				let current = getcurfile(window.location.href);

				if(mine.toLowerCase() == current.toLowerCase()){
					el.classList.add("current");
				}
			})
		});
	}
}

function renderItems() {
	const container = document.getElementById("itemsContainer");

	console.log(invoiceItems);

	if(container != undefined){
		container.innerHTML = "";
		titleShow.innerHTML = invoice_title;

		let total_unpaid = 0;
		let total_paid = 0;
		let prefix = "ksh.";

		invoiceItems.forEach((item, index) => {
			const div = document.createElement("div");

			if(item.amount.includes('/')){
				let [paid,total] = item.amount.split("/");

				total = Number(total);
				paid = Number(paid);

				let f = paid / total;
				let percent = f * 100;

				total_paid += paid;
				total_unpaid += (total - paid);

				div.className = "item complex";
				div.innerHTML = `
					<div>${item.invoice_item}</div>
					<div>
						<div class="w3-right">${Math.floor(percent)} %</div>
						<div>${prefix} ${paid.toLocaleString()} / ${total.toLocaleString()}</div>
						<div><progress min="0" max="100" value="${percent}"></div>
					</div>
				`;
			} else {
				let amt = Number(item.amount);
				total_unpaid += amt;

				div.className = "item simple";
				div.innerHTML = `
					<div>${item.invoice_item}</div>
					<div>${prefix} ${amt.toLocaleString()}</div>
				`;
			}

			container.appendChild(div);
		});

		totals.innerHTML = `
			<div class="item totals">
				<div>Total unpaid</div>
				<div><span class="themett bolden">${prefix} ${total_unpaid.toLocaleString()}</span></div>
			</div>
			<div class="item totals">
				<div>Total paid</div>
				<div><span class="themett bolden">${prefix} ${total_paid.toLocaleString()}</span></div>
			</div>
		`;
	} else {
		console.log('invoice container missing');
	}
}

function saveToLocal() {
	const title = invoice_title;
	const dataToSave = { title, items: invoiceItems};
	localStorage.setItem("invoiceData", JSON.stringify(dataToSave));
	alert("Saved to LocalStorage!");
}

function loadFromLocal() {
	const saved = localStorage.getItem("invoiceData");
	if (saved) {
		const parsed = JSON.parse(saved);
		invoice_title = parsed.title;
		invoiceItems = parsed.items;

		titleShow.innerHTML = invoice_title;

		renderItems();
		alert("Loaded from LocalStorage!");
	} else {
		alert("No data found in LocalStorage.");
	}
}

function deleteFromLocal() {
	localStorage.removeItem("invoiceData");
	logme_special('data deleted locally','w3-red');
}

function uploadData() {
	let accesstk = prompt("enter your passkey");


	if(accesstk == "corysentme"){
		const title = invoice_title;

		if(title == ""){
			// alert("give your invoice a title first!")
			logme("give your invoice a title first!");
			return;
		}

		const dataToSend = { title, items: invoiceItems };

		// Replace with your actual PHP endpoint URL
		const url = "uploadinvoice.php";

		setTimeout(async () => {
			try{
				let fetchreq = await fetch(url,{
					method: "post",
					headers: {
						'Content-Type':"application/json"
					},
					body: JSON.stringify({'inv_data' : dataToSend})
				})
				console.log('attempting upload');

				response = await fetchreq.text();

				logme(response);
			} catch(err){
				console.error(err);
			}
		},300);
	} else {
		alert("invalid passkey, try again");
	}
}

function getcurfile(href) {
	let pieces = href.split("/");
	let curfile = pieces[pieces.length - 1].split("?")[0];

	return curfile;
}
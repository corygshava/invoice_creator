let the_logbox = undefined;
let animtimeout = undefined;

function mek_log_box(dft) {
	dft = dft == undefined ? "im alive!" : dft;

	the_logbox = document.createElement("div");

	the_logbox.className = "logbox";
	the_logbox.id = "logbox";

	the_logbox.setAttribute('style',`
		position: fixed;
		bottom: 30px;
		left: 20px;
		background-color: black;
		padding: 8px 16px;
		border-radius: 16px;
		box-shadow: 0 0 12px #000000aa;
		pointer-events:none;
	`);

	document.body.appendChild(the_logbox);
	logme(`${dft}`);
}

function logme(m,con) {
	con = con == undefined ? true : con;
	if(con){the_logbox.className = "logbox";}
	if(animtimeout != undefined){clearTimeout(animtimeout);}

	runAnim();
	the_logbox.innerHTML = m;
}

function logme_special(m,extraclass) {
	the_logbox.className = extraclass;
	logme(m,false);
}

function runAnim() {
	// anims data
	const moveUp = the_logbox.animate([
			{ transform: 'translateY(0)',opacity: 0},
			{ transform: 'translateY(-50px)',opacity: 1}
		], {
			duration: 500,
			easing: 'ease-out',
			fill: "forwards"
		});

	// After moving up, wait 5 seconds and then move back down
	moveUp.onfinish = () => {
		animtimeout = setTimeout(() => {
			const moveDown = the_logbox.animate([
				{ transform: 'translateY(-50px)',opacity: 1},
				{ transform: 'translateY(0)',opacity: 0}
			], {
				duration: 500,
				easing: 'ease-in',
				fill: "forwards"
			});
		}, 5000); // 5 seconds delay
	};
}

function basicChartData(data,Chartid,label) {
	var rem = 100 - data;
	var label2 = 'Need to improved';
	var gaolData = {
		datasets: [{
			data: [data,rem],
			backgroundColor: [
			"#4BC0C0",
			"#FFCE56"
			],
	     	label: label // for legend
	    }],
	     labels: [
	     	label,
	     	label2
	     ]
     };

     var goal = document.getElementById(Chartid);
     console.log(goal);
     new Chart(goal, {
     	data: gaolData,
     	type: 'doughnut'
     });
}
	

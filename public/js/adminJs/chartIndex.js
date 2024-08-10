
// -----------------------chart pourcntage réussite définitive par cisco--------------------------------
let ciscoDataAttribute= document.querySelector('#ciscoChart').getAttribute('data-cisco-data');
let data= JSON.parse(ciscoDataAttribute);

let ciscoLabels = data.map(function(cisco){
    return cisco.cisco;
});

let ciscoPourcentage = data.map(function(cisco){
    return cisco.pourcentage;
});

let ctx = document.querySelector('#ciscoChart').getContext('2d');
// let myChart = new Chart(ctx, {
//     type: 'bar',
//     data: {
//         labels: ciscoLabels,
//         dataSets: [{
//             label: 'Pourcentage',
//             backgroundColor: 'rgba(75 192, 192, 0.2)',
//             borderColor: 'rgba(75, 192 192, 1)',
//             borderWidth: 1
//         }]
//     },
//     options: {
//         scales: {
//             y: {
//                 beginAtZero: true
//             }
//         }
//     }
// });

const barChart= new Chart (ctx, {
	type: "bar",
	data: {
		//labels: ["tana", "fianara", "Bira", "jungama"],
		labels: ciscoLabels,
		datasets: [{
			//data: [240, 120, 130, 100],
            label: 'Pourcentage',
			data: ciscoPourcentage,
			backgroundColor: [
				"aqua",
				"lightgreen",
				"lightblue",
				"violet"
			]
		}]
	},
	options: {
		scales: {
			y: {
				suggestedMax: 100,
				ticks: {
					font: {
						size: 12
					}
				}
			},
			x: {
				ticks: {
					font: {
						size: 12
					}
				}
			}
		}
	}
});

// ----------------------- fin chart pourcntage réussite définitive par cisco--------------------------------

//---------------------------------pie chart-----------------------------------------------------------------
const pieCanvas= document.querySelector("#pieCanvas");
let pourcentageReussiteEcrit= parseInt(document.querySelector('#pourcentageReussiteEcrit').innerText);
let pourcentageReussitePratique= parseInt(document.querySelector('#pourcentageReussitePratique').innerText);

const pieChart= new Chart(pieCanvas, {
	type: "pie",
	data: {
		labels: [
			'Ecrit',
			'Pratique'
		],
		datasets: [ {
			data: [pourcentageReussiteEcrit, pourcentageReussitePratique],
			backgroundColor: [
				'rgb(255, 99, 132)',
				'rgb(54, 162, 235)',
				
			],
			hoverOffset: 4
		}]
	}
})
$.ajax({
	url:"http://localhost/carbon_n_me/index.php",
	type: "GET",
	dataType:"json",
	success: function(data){
		console.log(data);
	}
});

var dataset = [ 572, 555, 398, 397, 393 ];

// Largeur et hauteur
var w = 300;
var h = 300;
var barPadding = 1;

// Crée l'élément SVG
var svg = d3.select("#graph")
            .append("svg")
            .attr("width", w)
            .attr("height", h);

svg.selectAll("rect")
   .data(dataset)
   .enter()
   .append("rect")
   .attr("x", function(d, i) {
    return i * (w / dataset.length);  // Largeur de barre de 20 plus 1 pour la marge
})
   .attr("y", function(d) {
    return h - d/2;  // Hauteur moins la valeur de la donnée
})
   .attr("width", w / dataset.length - barPadding)
   .attr("height", function(d) {
    return d/2;
})

   .attr("fill", function(d) {
    return "rgb(0, 0, " + (d * 10) + ")";
});

svg.selectAll("text")
   .data(dataset)
   .enter()
   .append("text")
   .text(function(d) {
        return d;
   })
   .attr("x", function(d, i) {
        return i * (w / dataset.length) + (w / dataset.length - barPadding) / 2;
   })
   .attr("y", function(d) {
        return h - (d/2) + 14;
   })
   .attr("font-family", "sans-serif")
   .attr("font-size", "11px")
   .attr("fill", "white")
   .attr("text-anchor", "middle");
$(document).ready(function(){
    charts();
});


function charts(){
     let dados = [];
     $.ajax({
       url: "/painel/dados",
       type: "GET", 
       dataType: 'json',
       success:function(response){
           let dados = response;
           chartMatriculas(dados.matriculas);
       }, 
     });
}

function chartMatriculas(matriculas){
    var options = {
      chart: {
          type: 'donut'
      },
      series: [],
      labels: [],
    }

    $.each(matriculas, function (index, matricula){
       setSeriesAndLabels(index,matricula, options) 
    });

    var chart = new ApexCharts(document.querySelector("#chart-matriculas"), options);

    chart.render();
 }

function setSeriesAndLabels(label, serie, options){
    options['labels'].push(label);
    options['series'].push(serie.length);
}

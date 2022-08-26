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
           dados = response;
           infoCardsDash(dados.cards);
           chartMatriculas(dados.matriculas);
           chartSemestres(dados.semestres);
           chartCursos(dados.cursos);
       }, 
     });
}

function infoCardsDash(cards){
    $('.info-dash-alunos').html(cards.alunos);
    $('.info-dash-cursos').html(cards.cursos);
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


function chartSemestres(semestres){
    var options = {
      chart: {
          type: 'donut'
      },
      series: [],
      labels: [],
      colors: ["#CE3B1C", "#1C6FCE", "#27CE1C", "#C11CCE", "#EBE80D", "#0DEBE8", "#A3242D", "#4B4545"],
    }

    $.each(semestres, function (index, semestre){
       setSeriesAndLabels(index + " Semestre", semestre, options) 
    });

    var chart = new ApexCharts(document.querySelector("#chart-semestres"), options);

    chart.render();
}


function setSeriesAndLabels(label, serie, options){
    options['labels'].push(label);
    options['series'].push(serie.length);
}



function chartCursos(alunos){
   let options = getBarModel();
       

   $.each(alunos, function (curso, numero_matriculas){
      options['series'][0]['data'].push(setSerieBar(curso, numero_matriculas));
   });

   options['yaxis']= 
    `[
      labels: {
        formatter: function(val) {
          return val.toFixed(0);
        }
      }
    }]`;
  
   var chart = new ApexCharts(document.querySelector("#chart-cursos"), options);
  
   chart.render();
}

function getBarModel(){
    var options = {
        chart: {
            type: 'bar',
            width: '98%',
            height: '200%'
        },
        plotOptions: {
            bar: {
              horizontal: true
            }
        },
        series: [{
            data: [ 
            
            ]
        }],
        tooltip: {
            style: {
                textAlign: "center",
            },
            x: {
                show: true,
            },
            y:{
                formatter: function(val){
                    return val.toFixed(0);
                }, 
                title: {
                    formatter: function() {
                       return 'Alunos Matriculados:';
                    }
                },
            },
        },
    }
    return options;
} 

function setSerieBar(curso, numero_matriculas){
  let randomColor = Math.floor(Math.random()*16777215).toString(16);
  let serie =  {
      x: curso,
      y: numero_matriculas.length,
      fillColor: "#"+randomColor,
  }
  return serie;
}

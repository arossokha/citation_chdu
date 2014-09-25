<?php

    $topRateArticles = Article::model()->findAll(array(
                'limit' => '10',
                'order' => '`index` DESC',
                ));

    $topRatesNames = array_map(function($article) {
        return [$article->name,"<a href=\"{$article->file}\"> <img style=\"height: 50px; width 50px;\" src='/images/pdf.png'> </a>"];
    },$topRateArticles);

    $topRatesIndexes = array_map(function($article) {
        return $article->index-0;
    },$topRateArticles);

    $authorArticles = Author::model()->findAll(array(
                'limit' => '10',
                'order' => 'COUNT(articles.articleId) DESC',
                'with' => 'articles',
                'group' => 't.authorId',
                'together' => true,
                ));

    $authorArticlesNames = array_map(function($author) {
        return [$author->fullName,"<a href=\"/author/{$author->authorId}\"> {$author->fullName} </a>"];
    },$authorArticles);

    $authorArticlesCount = array_map(function($author) {
        return $author->getWorkCount();
    },$authorArticles);

    $citatedCount = Yii::app()->db->createCommand(" SELECT COUNT(articleId) as c FROM Article where `index` > 0 ")->queryScalar();
    $notCitatedCount = Yii::app()->db->createCommand(" SELECT COUNT(articleId) as c FROM Article where `index` <= 0 ")->queryScalar();

    $currentYear = date('Y');
    $years = range($currentYear - 10,$currentYear,1);

    $sql  =" SELECT year,COUNT(articleId) as c FROM Article where `index` > 0 
        AND `year` IN (".implode(',',$years). ") GROUP BY `year` ";

    $res = Yii::app()->db->createCommand($sql)->queryAll();

    $citatedArticlesWithYear = array();
    foreach ($res as $row) {
        $citatedArticlesWithYear[$row['year']] = $row['c'];
    }

    $citatedArticlesCount = array();
    foreach ($years as $year) {
        $citatedArticlesCount[] = isset($citatedArticlesWithYear[$year]) ? $citatedArticlesWithYear[$year] - 0 : 0;
    }

    // echo "<pre>";
    // var_dump($citatedArticlesCount);
    // die();

?>
<script>
$(document).ready(function(){

    $('#top-rate-articles').highcharts({
        colors : ['#64BCAA'],
        chart: {
            backgroundColor : '#F8F8EC',
            type: 'column'
        },
        title: {
            style : {
                fontFamily : "College",
            },
            text: 'Top 10 articles'
        },
        xAxis: {
            categories: <?php echo CJSON::encode($topRatesNames); ?>,
            labels: {
                formatter : function () {
                    return this.value[1];
                },
                useHTML : true,
            }
        },
        yAxis: {
            min: 0,
            max: 2,
            title: {
                text: 'Indexes'
            }
        },
        tooltip: {
            formatter : function() {
                return this.x[0];
            },
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        series: [{
            name: 'Articles',
            data: <?php echo CJSON::encode($topRatesIndexes); ?>
            
        }]
    });

$('#author-articles').highcharts({
        colors : ['#E6A810'],
        chart: {
            backgroundColor : '#F8F8EC',
            type: 'column'
        },
        title: {
            style : {
                fontFamily : "College",
            },
            text: 'Author articles'
        },
        xAxis: {
            categories: <?php echo CJSON::encode($authorArticlesNames); ?>,
            labels: {
                formatter : function () {
                    return this.value[1];
                },
                useHTML : true,
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Articles count'
            }
        },
        tooltip: {
            formatter : function() {
                return this.x[0];
            },
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        series: [{
            name: 'Authors',
            data: <?php echo CJSON::encode($authorArticlesCount); ?>
            
        }]
    });

    $('#pie-chart').highcharts({
        colors : ['#E6A810','#64BCAA'],
        chart: {
            backgroundColor : '#F8F8EC',
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false
        },
        title: {
            style : {
                fontFamily : "College",
            },
            text: 'Percent of citated articles'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Citated articles',
            data: [
                ['Citated',     <?php echo $citatedCount; ?>],
                ['Not citated', <?php echo $notCitatedCount; ?>],
            ]
        }]
    });

     $('#spline-graph').highcharts({
        colors : ['#E6A810'],
        chart: {
            backgroundColor : '#F8F8EC',
            type: 'spline'
        },
        title :  {
            style : {
                fontFamily : "College",
            },
            text: "Citated articles by years",
        },
        xAxis: {
            categories: <?php echo CJSON::encode($years); ?>
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Article'
            },
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        series: [{
            name : 'Count ',
            marker: {
                symbol: 'square'
            },
            data: <?php echo CJSON::encode($citatedArticlesCount); ?>
        }]
    });

});
</script>


<div class="author-info" id="top-rate-articles" style="margin-bottom: 20px; border: 3px dashed #E6BA1E; min-width: 310px; height: 400px; "></div>

<div class="author-info" id="author-articles" style="margin-bottom: 20px; min-width: 310px; height: 400px; "></div>

<div class="author-info" id="pie-chart" style="margin-bottom: 20px; min-width: 310px; height: 400px; max-width: 600px; "></div>

<div class="author-info" id="spline-graph" style="min-width: 310px; height: 400px; "></div>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/market.css');
?>
<div class="marker-header"
     style="background: url(<?php echo Yii::app()->baseUrl . '/images/market-header.png'; ?>) top left/100% 100% no-repeat;">
    <div class="row">
        <div class="col-md-5 header-logo">
            <img src="<?php echo Yii::app()->baseUrl ?>/images/cvslogo.png">
            <span><?= date('Y') . ' ' . Yii::t('cvs', '可口可乐便利店渠道奖励计划'); ?></span>
        </div>
        <div class="col-md-7">
            <ul class="header-right">
                <!--                <li>-->
                <!--                    <div class="search input-group">-->
                <!--                        <input type="text" class="form-control" placeholder="搜索"/>-->
                <!--                    <span class="input-group-btn">-->
                <!--                        <button class="btn btn-info btn-search">-->
                <!--                            <i class="glyphicon glyphicon-search"></i>-->
                <!--                        </button>-->
                <!--                    </span>-->
                <!--                    </div>-->
                <!--                </li>-->
                <li>
                    <span title="跳转页面"><a href="<?= $this->createUrl('site/indexcvs');?>"  style="color: white"><?= Yii::t('cvs', '全国指标'); ?></a></span>
                </li>
                <li><span><a href="<?php echo Yii::app()->createUrl('site/store'); ?>">基本详情页</a></span></li>
                <li>
                <span>
                    <?php
                    if (Yii::app()->language == 'zh_cn') {
                        echo CHtml::link('中', array('Site/ChangeLanguage', 'language' => 'zh_cn'), array('class' => 'changeRed', 'title' => '切换为中文'));
                        ?>
                        <i class="glyphicon glyphicon-resize-horizontal"></i>
                        <?php
                        echo CHtml::link('En', array('Site/ChangeLanguage', 'language' => 'es'), array('title' => Yii::t('cvs', '切换为英文')));
                    } elseif (Yii::app()->language == 'es') {
                        echo CHtml::link('中', array('Site/ChangeLanguage', 'language' => 'zh_cn'), array('title' => '切换为中文'));
                        ?>
                        <i class="glyphicon glyphicon-resize-horizontal"></i>
                        <?php
                        echo CHtml::link('En', array('Site/ChangeLanguage', 'language' => 'es'), array('class' => 'changeRed', 'title' => Yii::t('cvs', '切换为英文')));
                    }
                    ?>
                </span>
                </li>
                <!--                <li>-->
                <!--                    <div class="dropdown">-->
                <!--                    <span data-toggle="dropdown" title="下载月报或者期报">-->
                <!--                        --><? //= Yii::t('cvs', '下载'); ?>
                <!--                        <i class="caret"></i>-->
                <!--                    </span>-->
                <!--                        <ul class="dropdown-menu">-->
                <!--                            <li id="monthly_Reportz" data-toggle="modal" data-target="#myModal">-->
                <!--                                <a href="#">--><? //= Yii::t('cvs', '报告'); ?><!--</a>-->
                <!--                            </li>-->
                <!--                        </ul>-->
                <!--                    </div>-->
                <!--                </li>-->
                <li>
                    <div class="user dropdown">
                    <span data-toggle="dropdown">
                        <?php echo BSHtml::image(Yii::app()->baseUrl . "/images/person1.png"); ?>GUEST
                        <i class="caret"></i>
                    </span>
                        <ul class="dropdown-menu">
                            <li data-toggle="modal" data-target="#myModal" data-target="#myModal">
                                <a href="<?php echo Yii::app()->createUrl('site/logout'); ?>"><?= Yii::t('cvs', '退出登录'); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="row market-bottom">
        <div class="col-md-4 market-bottom-div">
            <div>Tier A</div>
            <div><?= isset($data['rank']['TierA']) ? Yii::t('cvs', $data['rank']['TierA']) : '无数据'; ?></div>
        </div>
        <div class="col-md-4 market-bottom-div">
            <div>Tier B</div>
            <div><?= isset($data['rank']['TierB']) ? Yii::t('cvs', $data['rank']['TierB']) : '无数据'; ?></div>
            <div><?= isset($data['rankSecond']['TierB']) ? Yii::t('cvs', $data['rankSecond']['TierB']) : '无数据'; ?></div>
        </div>
        <div class="col-md-4 market-bottom-div">
            <div>Tier C</div>
            <div><?= isset($data['rank']['TierC']) ? Yii::t('cvs', $data['rank']['TierC']) : '无数据'; ?></div>
            <div><?= isset($data['rankSecond']['TierC']) ? Yii::t('cvs', $data['rankSecond']['TierC']) : '无数据'; ?></div>
        </div>
    </div>
</div>
<div class="main-list">
    <div>
        <a style="color: red;" href="<?php echo $this->createUrl('site/market', array('type' => $type)); ?>"
           class="sorts <?php if ($type != 'rank') {
               echo 'active';
           } ?>">
            <img class="ver" src="<?php echo Yii::app()->baseUrl ?>/images/sort.png" alt="">
            <?= Yii::t('cvs', '排名') ?>
        </a>
    </div>
    <div><?= Yii::t('cvs', '装瓶厂'); ?></div>
    <div><?= Yii::t('cvs', '客户数量'); ?></div>
    <div><?= Yii::t('cvs', '单店销量'); ?>(VPO)<?= Yii::t('cvs', '得分'); ?></div>
    <div><?= Yii::t('cvs', '单店销售收入'); ?><?= Yii::t('cvs', '得分'); ?></div>
    <div title="各厂全年总销量和销售收入两项指标中有任意一项低于2017年（负增长），将不具备评奖资格" style="cursor: pointer"><?= Yii::t('cvs', '门槛'); ?></div>
    <div><?= Yii::t('cvs', '执行'); ?><?= Yii::t('cvs', '得分'); ?></div>
    <div><?= Yii::t('cvs', '总分'); ?></div>
    <div>
        <?= Yii::t('cvs', '竞赛分组'); ?>
        <span class="market-export js-rb-export" title="导出该模块" t="market"></span>
    </div>
</div>
<?php
//支持csrf安全验证
$form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id'=>'imgs-form',
    'enableAjaxValidation'=>false,
    'action'=>array("zipimg"),
    'htmlOptions'=>array("class"=>"hide")
));

$this->endWidget();
?>
<?php
    foreach ($data['market'] as $key => $value) {
//    pd($value);

    ?>
<!--    <div class="main-m">-->
        <div class="aaa">
            <?php
            $a = [];
            for ($i = 0; $i < count($value); $i++) {
                ?>
                <div class="market <?php if ($value[$i]['rank'] == '第一名') {
                    echo 'first';
                } elseif ($value[$i]['rank'] == '第二名') {
                    echo 'second';
                } elseif ($value[$i]['rank'] == '第三名') {
                    echo 'third';
                } ?> <?php if($value[$i]['rank'] == '第二名' && ($value[$i]['competition_grouping'] == 'TierB' || $value[$i]['competition_grouping'] == 'TierC')){
                    echo 'TierBSecond';
                }?>">
                    <div><?= Yii::t('cvs', $value[$i]['rank']); ?></div>
                    <div><?= Yii::t('cvs', $value[$i]['channel']['name']); ?></div>
                    <div><?= $value[$i]['banner_number']; ?></div>
                    <div><?= sprintf("%.2f",$value[$i]['volume_per_outlet']); ?></div>
                    <div><?= sprintf("%.2f",$value[$i]['sales_revenue']); ?></div>
                    <div><?= $value[$i]['doorsill']; ?></div>
                    <?php
                    $city = substr($value[$i]['channel']['name'], 4);
                    if ($city == "广东东") {
                        $city = "粤东";
                    } elseif ($city == "广东西") {
                        $city = "粤西";
                    }
                    ?>
                    <div><?= sprintf("%.2f",$value[$i]['execution']); ?><a class="score-detail"
                                                                       href="<?= $this->createUrl('site/indexcvs',['m_city' => $value[$i]['channel']['r_id']]); ?>"><?= Yii::t('cvs', '详情'); ?></a>
                    </div>
                    <div><?= sprintf("%.2f",$value[$i]['total_score']); ?></div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="last-market">
            <?= 'Tier ' . substr($key, 4); ?>
        </div>
<!--    </div>-->
    <?php
}
?>
<script src="<?php echo Yii::app()->baseUrl.'/js/html2canvas.js' ;?>"></script>
<script>
    $(function () {
        var timerm3 = null;
        var timerm4 = null;
        var timerm5 = null;
        for (let i = 0; i < $('.aaa').length; i++) {
            $(".last-market").eq(i).css({
                'height': $('.aaa').eq(i).height() + 'px',
                'line-height': $('.aaa').eq(i).height() + 'px',
                'font-size': '16px',
                'font-weight': 'bold',
                'background-color': 'white'
            })
        }
//        for (let j = 0; j < $('.market-main').length; j++) {
//            var attr = $('.market-main').eq(j).find('.first').attr('idx');
//            $('.rborder').eq(j).css({
//                'top': attr * 50 + 10 + 'px',
//                'display': 'block'
//            })
//        }
        $(document).on('click', '.rborder', function () {
            window.location.href = "--><?= $this->createUrl('site/indexcvs');?>//";
        });

        $(document).on('click','.js-rb-export',function(){
            $('.js-rb-export').hide();
            let clickItem = $(this).attr('t');
            $('<div>',{
                class:'fixed-mb'
            }).appendTo('body');
            $("#imgs-form input[name!='YII_CSRF_TOKEN']").remove();

            switch (clickItem){
                case 'market':
                    var arrList = [''];
                    var _name = "可口可乐便利店渠道奖励计划";
                    console.log(_name);
                    exSingle('#page',arrList,0,0,_name);
                    break;
                default:
                    var arrList = ['#dp1','#dp2','#dp3']
                    var _name = $('#Search_month').val()  + '_图表_';
                    exSingle('#chart-view',arrList,0,600,_name,$('#vitab').html());
            }

        });

        function exSingle(el,arr,i,time,n,m){
            var eName = n + (m?m:$(arr[i]).attr('con'));
            console.log(eName);
            if(arr.length>0){
                $(arr[i]).trigger('click');
            }
            if(arr[i]=='#dp3'){
                clearInterval(timerm5);
                timerm5 = setInterval(function(){
                    if($('#chart-view').children('.mb-fff').length<=0){
                        clearInterval(timerm5);
                        method2();
                    }
                },100)
            }else{
                method2()
            }
            function method2(){
                clearTimeout(timerm3);
                $('.chart-box').height('auto');
                timerm3 = setTimeout(function(){
                    html2canvas($(el), {
                        background:'#fff',
                        onrendered: function(canvas) {
                            var url = canvas.toDataURL();
                            console.log('url.length',url.length)
                            $("<textarea name='"+eName+"'>"+url+"</textarea>").appendTo("#imgs-form");
                            console.log($('#imgs-form textarea').eq(0).val().length)
                            i++;
                            if(i<arr.length){
                                exSingle(el,arr,i,time,n,m);
                            }else{
                                // console.log($('#imgs-form').find('input').length)
                                console.log($(el).outerHeight())
                                $('#imgs-form').submit();
                                $('.fixed-mb').remove();
                                $('.chart-box').height('480px');
                                $('.js-rb-export').show();
                            }

                        },
                        width: $(el).outerWidth(),
                        height: $(el).outerHeight(),
                    })
                }, time);
            }

        }
    });
    //导出此模块
</script>

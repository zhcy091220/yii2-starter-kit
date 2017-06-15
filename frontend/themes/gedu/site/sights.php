<?php
use yii\helpers\Html;

$school=[
    '1'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-2.png?imageView2/1/w/500/h/400',
      'name'=>'教学楼',
      'school'=>'光大学校教学楼'
      ],
    '2'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-1.png?imageView2/1/w/500/h/400',
      'name'=>'教学楼',
      'school'=>'光大学校教学楼'
      ],
    '3'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/main-3-3.png?imageView2/1/w/500/h/400',
      'name'=>'讲台',
      'school'=>'光大学校讲台'
      ],
    '4'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/jiaoxuelou.jpg?imageView2/1/w/500/h/400',
      'name'=>'教学楼',
      'school'=>'光大学校教学楼'
      ],
    '5'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/guangdapeitao.jpg?imageView2/1/w/500/h/400',
      'name'=>'教学楼',
      'school'=>'光大学校教学楼'
      ],
    '6'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/guangdapei.jpg?imageView2/1/w/500/h/400',
      'name'=>'教学楼',
      'school'=>'光大学校教学楼'
      ],
    '7'=>[
      'img'=>'http://7xsm8j.com2.z0.glb.qiniucdn.com/guagndasmal.jpg?imageView2/1/w/500/h/400',
      'name'=>'教学楼',
      'school'=>'光大学校教学楼'
      ],
 ];
?>
?>
<div class="gdu-content">
  <div class="row">
    <!-- 左边侧边栏 -->
    <?php
      echo $this->render('@frontend/themes/gedu/page/common/sidebarteacher');
    ?>
    <!-- 文章内容部分 -->
    <div class="col-md-8 ">
      <div class="box box-widget geu-content">
            <div class="box-header with-border ">
              <div class="">
                <ol class="breadcrumb">
                  <li><?php echo Html::a('首页',['site/index'])?></li>
                  <li class="activeli">校园风光</li>
                </ol>
              </div>
            </div>
            <div class="box-body">
                <div class="demo">
                  <div class="">
                    <div class="row teabor">
                    <?php foreach($school as $key =>$value){?>
                      <ul class="col-md-4 col-sm-6">
                        <li>
                          <div class="port-7 effect-2">
                            <div class="image-box">
                              <img class="img-responsive" src="<?php echo $value['img'];?>" alt="Photo">
                            </div>
                            <div class="text-desc">
                              <h4><?php echo $value['name'];?></h4>
                              <p><?php echo $value['school'];?></p>
                            </div>
                          </div>
                        </li>
                        
                      </ul>
                      <?php }?>
                    </div>
                  </div>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>
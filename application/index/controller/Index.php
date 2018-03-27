<?php
namespace app\index\controller;

use think\Db;
use think\Request;
use think\Controller;
use think\Loader;
use Think\Model;
use ajax\Page;
//use app\index\model\Music;

class Index extends Controller
{
	use \traits\controller\Jump;
	public function _empty()
	{
		echo 123123123;
	}
        public function _initialize()
    {
         $link = model('link')->clink();
         $this->assign('link',$link);
    }

     public function index()
    {
         $data = model('music')->mulist();
         $albu = model('album')->album();
         $singer = model('singer')->tsinger();
         $mv = model('mv')->top();
        
         $top = model('music')->toplist();
         $to = model('music')->topli();
         $pic = model('pic')->piclist();
         //dump($pic);die;
         $this->assign('pic',$pic);
         $this->assign('a',$albu);
        $this->assign('mv',$mv);
        $this->assign('tl',$to);
        $this->assign('top',$top);
        //dump($singer);die;
        $this->assign('mus',$data);
        $this->assign('tsinger',$singer);
        return $this->fetch('home/index');

    }
     public function classe()
	{
            $data = model('music')->cmlist();
            $res = model('cate')->catetree();
            //dump($data);die;
            $this->assign('data',$data);
            $this->assign('cate',$res);
            return $this->fetch('home/classe');

	}
     public function music()
    {
         //接收歌曲id 并传入model
        $id = input('param.id');
        $res = model('like')->islike($id);
        $data = model('music')->minfo($id);
        $mut = model('music')->mut();
        $this->assign('like',$res);
        $this->assign('minfo',$data);
        $this->assign('mut',$mut);
        return $this->fetch('home/music');

    }
    
    public function like()
    {
         $mut = model('like')->addlike();
         if($mut){
              $this->success('收藏成功');
         }else{
             $this->error('收藏失败');
         }
    }
    
    public function good()
    {
         $mut = model('music')->good();
         if($mut){
              $this->success('点赞成功');
         }else{
             $this->error('点赞失败');
         }
    }
    
     public function bad()
    {
         $mut = model('music')->bad();
         if($mut){
              $this->success('差评成功');
         }else{
             $this->error('差评失败');
         }
    }
    
    public function nolike()
    {
         $mut = model('like')->dellike();
         if($mut){
             $this->success('取消成功');
         }else{
             $this->error('取消失败');
         }
    }

    
    public function mv()
    {
        $mut = model('mv')->top();
        $lie = model('mv')->lie();
        $re = model('mv')->rebo();
        $cate = model('mvtype')->cate();
        $this->assign('cate',$cate);
        $this->assign('re',$re);
        $this->assign('lie',$lie);
        $this->assign('top',$mut);
        return $this->fetch('home/mv');

    }
    //音乐列表页
     public function rank()
    {
        $data = model('music')->lists();
        //最热推荐
        $hit = model('music')->hit();
        //好评推荐
        $good = model('music')->isgood();
        $wek = model('music')->week();
        $res = model('cate')->catetree();
        //dump($res);die;
        $this->assign('music',$data);
        $this->assign('wek',$wek);
        $this->assign('good',$good);
        $this->assign('hit',$hit);
        $this->assign('cate',$res);
        return $this->fetch('home/rank');

    }
    //搜索页
     public function search()
    {   $con = input('param.con');
        $data = model('music')->search();
        $c = count($data);
         $this->assign('data',$data);
          $this->assign('c',$c);
           $this->assign('con',$con);
        return $this->fetch('home/search');

    }
    //歌手详情页
     public function singer()
    {
        $data = model('singer')->sinfo();
        $music = model('music')->sm();
        $ablum = model('album')->lists();
        $mv = model('mv')->lists();
        //dump($music);die;
        $this->assign('mv',$mv);
        $this->assign('ab',$ablum);
        $this->assign('music',$music);
        $this->assign('data',$data);
        return $this->fetch('home/singer');

    }
    //歌手分类页
     public function singer_class()
    {
        $data = model('singer')->lists();
        $res = model('Singertype')->lists();
        $this->assign('class',$res);
        $this->assign('singer',$data);
        return $this->fetch('home/singer_class');

    }
    //根据类别找歌手
     public function sinclass()
    {
        $data = model('singer')->sinlist();
        $res = model('Singertype')->lists();
        $this->assign('class',$res);
        $this->assign('singer',$data);
        return $this->fetch('home/sinclass');

    }
    //歌手搜索页
      public function singer_search()
    {
        $con = input('param.con');
        $data = model('singer')->search();
        $c = count($data);
        $this->assign('data',$data);
        $this->assign('c',$c);
        $this->assign('con',$con);
        return $this->fetch('home/singer_search');

    }
     public function special_search()
    {
        $con = input('param.con');
        $data = model('album')->search();
        $c = count($data);
        $this->assign('data',$data);
        $this->assign('c',$c);
        $this->assign('con',$con);
        return $this->fetch('home/special_search');

    }
    //专辑
      public function special()
    {
          
        $data = model('album')->info();
        //歌手其他专辑
        $res = model('album')->exm();
        $m = model('music')->abm();
        $this->assign('ab',$data);
        $this->assign('res',$res);
        $this->assign('m',$m);
        return $this->fetch('home/special');

    }
    //专辑分类
      public function special_class()
    {
          
        $res = model('albumtype')->lists();
        $data = model('albumtype')->album();
     
        $count = count($data);
        $page = new Page(5,$count);
        $limit = $page->limit();
        $data = model('albumtype')->albumlimit($limit);
        $this->assign('data',$data);
        $this->assign('res',$res);
        return $this->fetch('home/special_class');

    }
    
      public function speajax()
    {
          
        $res = model('albumtype')->lists();
        $data = model('albumtype')->album();
     
        $count = count($data);
        $page = new Page(5,$count);
        $limit = $page->limit();
        
        $data = model('albumtype')->albumlimit($limit);
        //$info = ['info'=>$data];
        $url = $page->allPage();
        $arr = ['info'=>$data,'url'=>$url];
       echo json_encode($arr);

    }
    //根据id查找内容
     public function speclass()
    {
        
        $res = model('albumtype')->lists();
        $data = model('albumtype')->albumtip();
        $this->assign('data',$data);
        $this->assign('res',$res);
        return $this->fetch('home/speclass');

    }
    //mv详情
      public function video()
    {
        $data = model('mv')->mvinfo();
        $top = model('mv')->istop();
        $this->assign('mv',$data);
         $this->assign('top',$top);
        return $this->fetch('home/video');

    }
    //mv类别
     public function vidclass()
    {
        $data = model('mv')->lie();
         $cate = model('mvtype')->cate();
        $this->assign('cate',$cate);
        $this->assign('mv',$data);
        return $this->fetch('home/vidclass');

    }
    
      public function video_class()
    {
        $data = model('mv')->clalist();
         $cate = model('mvtype')->cate();
        $this->assign('cate',$cate);
        $this->assign('mv',$data);
        return $this->fetch('home/video_class');

    }
    //mv搜索
      public function video_search()
    {
        $con = input('param.con');
        $data = model('mv')->search();
        $c = count($data);
        $this->assign('data',$data);
        $this->assign('c',$c);
        $this->assign('con',$con);
        return $this->fetch('home/video_search');

    }
    
    
 
	public function create()
	{
		// 插入记录
		/*$result = Db::execute('insert into think_data (id, name ,status) values (5, "thinkphp",
		1)');
		dump($result);*/
		// 查询数据
		/*$result = Db::query('select * from think_data where id = 5');
		dump($result);*/
		$list = Db::name('data')
				->where('id', '<>' ,18)
				->column('name');
		dump($list);
	}
}

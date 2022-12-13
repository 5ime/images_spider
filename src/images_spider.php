<?php
/**
 * @package Images_spider
 * @author  iami233
 * @version 1.0.0
 * @link    https://github.com/5ime/Images_spider
**/

namespace Images_spider;
class Images
{
    public function douyin($url) {
        $loc = get_headers($url, true) ['Location'][1];
        preg_match('/note\/(.*)\?/', $loc, $id);
        $arr = json_decode($this->curl('https://www.iesdouyin.com/web/api/v2/aweme/iteminfo/?item_ids=' . $id[1]), true);
        $img = $arr['item_list'][0]["images"];
        $images = array();
        for($i=0;$i<count($img);$i++){
            $none = $img[$i]["url_list"][count($img[$i]["url_list"])-1];
            array_push($images,$none);
        }
        if (!empty($images)){
            $Json = array(
                'code' => 200,
                'msg' => 'success',
                'count' => count($img),
                'images' => $images
            );
            return $Json;
        }
    }

    public function pipixia($url){
		$loc = get_headers($url, true)['Location'];
        preg_match('/item\/(.*)\?/',$loc,$id);
        $arr = json_decode(file_get_contents('https://is.snssdk.com/bds/cell/detail/?cell_type=1&aid=1319&app_name=super&cell_id='.$id[1]),true);
        $img = $arr['data']["data"]['item']['note']["multi_thumb"];
        $images = array();
        for($i=0;$i<count($img);$i++){
            $none = $img[$i]["url_list"][0]["url"];
        	array_push($images,$none);
		}
        if (!empty($images)){
			$Json = array(
				'code' => 200,
				'msg' => 'success',
				'count' => count($img),
				'images' => $images
			);
            return $Json;
        }
    }

    public function weibo($url){
        $cookie = "login_sid_t=6b652c77c1a4bc50cb9d06b24923210d; cross_origin_proto=SSL; WBStorage=2ceabba76d81138d|undefined; _s_tentry=passport.weibo.com; Apache=7330066378690.048.1625663522444; SINAGLOBAL=7330066378690.048.1625663522444; ULV=1625663522450:1:1:1:7330066378690.048.1625663522444:; TC-V-WEIBO-G0=35846f552801987f8c1e8f7cec0e2230; SUB=_2AkMXuScYf8NxqwJRmf8RzmnhaoxwzwDEieKh5dbDJRMxHRl-yT9jqhALtRB6PDkJ9w8OaqJAbsgjdEWtIcilcZxHG7rw; SUBP=0033WrSXqPxfM72-Ws9jqgMF55529P9D9W5Qx3Mf.RCfFAKC3smW0px0; XSRF-TOKEN=JQSK02Ijtm4Fri-YIRu0-vNj";
	    $data = $this->get_curl($url,$cookie);
        preg_match('/&pic_ids=(.*?)&mid=/',$data,$arr);
        $img = explode(",",$arr[1]);
		$images = array();
		for($i=0;$i<count($img);$i++){
			$none = 'https://lz.sinaimg.cn/oslarge/'.$img[$i].'.jpg';
			array_push($images,$none);
		}
        if (!empty($data)){
            $arr = array(
				'code' => 200,
				'msg' => 'success',
				'count' => count($img),
				'images' => $images
			);
            return $arr;
        }
    }

    public function zuiyou($url){
		$text = file_get_contents($url);
		preg_match_all('/<img alt="" src=\"(.*?)\"/',$text,$img);
        $images = array();
        for($i=0;$i<count($img[1]);$i++){
            $none = $img[1][$i];
        	array_push($images,$none);
        }
        if (!empty($images)){
            $arr = array(
				'code' => 200,
				'msg' => 'success',
				'count' => count($img[1]),
				'images' => $images
            );
            return $arr;
        }    
    }

    public function xhs($url){
        $loc = get_headers($url,1)["Location"];
        $cookie = "xhsTrackerId=e6018ab9-6936-4b02-cb65-a7f9f9e22ea0; xhsuid=y2PCwPFU9GCQnJH8; timestamp2=20210607d2293bcc8dcad65834920376; timestamp2.sig=QFn2Zv9pjUr07KDlnh886Yq43bZxOaT6t3WCzZdzcgM; xhsTracker=url=noteDetail&xhsshare=CopyLink; extra_exp_ids=gif_exp1,ques_exp2'";
		$text = $this->get_curl($loc,$cookie);
		preg_match_all('/imageList\":(.*?)\,\"cover/',$text,$img);
        $img = json_decode(str_replace('\\','/',str_replace('u002F','',$img[1][0])),1);
        $images = array();
        for($i=0;$i<count($img);$i++){
            $none = $img[$i]['traceId'];
        	array_push($images,'https://ci.xiaohongshu.com/'.$none);
        }
        if (!empty($images)){
			$Json = array(
				'code' => 200,
				'msg' => 'success',
				'count' => count($img),
				'images' => $images
			);
            return $Json; 
        } 
    }

    public function kuaishou($url){
		$loc = get_headers($url,1)['Location'];
		$url = $this->curl($loc[0]);
		preg_match('/imageCDN\":\"tx2.a.yximgs.com\",\"images\":(.*?)\],\"width/',$url,$arr);
        $img = json_decode($arr[1].']',true);
		$images = array();
		for($i=0;$i<count($img);$i++){
			$none = 'http://tx2.a.yximgs.com/'.$img[$i]['path'];
			array_push($images,$none);
		}
		if (!empty($arr)){
            $arr = array(
				'code' => 200,
				'msg' => 'success',
				'count' => count($img),
				'images' => $images
            );
            return $arr;
        }
    }

    private function curl($url,$headers=[])
    {
        $header = array( 'User-Agent:Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1');
        $con = curl_init((string)$url);
        curl_setopt($con,CURLOPT_HEADER,False);
        curl_setopt($con,CURLOPT_SSL_VERIFYPEER,False);
        curl_setopt($con,CURLOPT_RETURNTRANSFER,true);
        if (!empty($headers)) {
            curl_setopt($con,CURLOPT_HTTPHEADER,$headers);
        } else {
            curl_setopt($con,CURLOPT_HTTPHEADER,$header);
        }
        curl_setopt($con,CURLOPT_TIMEOUT,5000);
        $result = curl_exec($con);
        return $result;
    }

    private function get_curl($url,$cookie){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.128 Safari/537.36");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
?>
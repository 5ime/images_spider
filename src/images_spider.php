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
        $loc = get_headers($url, true) ['Location'];
        preg_match('/\/video\/(\d+)\//', $loc, $id);
        // 关于这里的第三方接口问题 请查看 https://github.com/5ime/images_spider#faq
        $url = 'https://tiktok.iculture.cc/X-Bogus';
        $data = json_encode(array('url' => 'https://www.douyin.com/aweme/v1/web/aweme/detail/?aweme_id=' . $id[1] . '&aid=1128&version_name=23.5.0&device_platform=android&os_version=2333','user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36'));
        $header = array('Content-Type: application/json');
        $url = json_decode($this->curl($url, $header, $data), true)['param'];
        
        $msToken = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 107);
        $header = array('User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'Referer: https://www.douyin.com/', 'Cookie: msToken='.$msToken.';odin_tt=324fb4ea4a89c0c05827e18a1ed9cf9bf8a17f7705fcc793fec935b637867e2a5a9b8168c885554d029919117a18ba69; ttwid=1%7CWBuxH_bhbuTENNtACXoesI5QHV2Dt9-vkMGVHSRRbgY%7C1677118712%7C1d87ba1ea2cdf05d80204aea2e1036451dae638e7765b8a4d59d87fa05dd39ff; bd_ticket_guard_client_data=eyJiZC10aWNrZXQtZ3VhcmQtdmVyc2lvbiI6MiwiYmQtdGlja2V0LWd1YXJkLWNsaWVudC1jc3IiOiItLS0tLUJFR0lOIENFUlRJRklDQVRFIFJFUVVFU1QtLS0tLVxyXG5NSUlCRFRDQnRRSUJBREFuTVFzd0NRWURWUVFHRXdKRFRqRVlNQllHQTFVRUF3d1BZbVJmZEdsamEyVjBYMmQxXHJcbllYSmtNRmt3RXdZSEtvWkl6ajBDQVFZSUtvWkl6ajBEQVFjRFFnQUVKUDZzbjNLRlFBNUROSEcyK2F4bXAwNG5cclxud1hBSTZDU1IyZW1sVUE5QTZ4aGQzbVlPUlI4NVRLZ2tXd1FJSmp3Nyszdnc0Z2NNRG5iOTRoS3MvSjFJc3FBc1xyXG5NQ29HQ1NxR1NJYjNEUUVKRGpFZE1Cc3dHUVlEVlIwUkJCSXdFSUlPZDNkM0xtUnZkWGxwYmk1amIyMHdDZ1lJXHJcbktvWkl6ajBFQXdJRFJ3QXdSQUlnVmJkWTI0c0RYS0c0S2h3WlBmOHpxVDRBU0ROamNUb2FFRi9MQnd2QS8xSUNcclxuSURiVmZCUk1PQVB5cWJkcytld1QwSDZqdDg1czZZTVNVZEo5Z2dmOWlmeTBcclxuLS0tLS1FTkQgQ0VSVElGSUNBVEUgUkVRVUVTVC0tLS0tXHJcbiJ9');

        $arr = json_decode($this->curl($url, $header), true);
        $img = $arr["aweme_detail"]["images"];
        $images = array();
        for($i=0;$i<count($img);$i++){
            $none = $img[$i]["url_list"][0];
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

    private function curl($url, $header = null, $data = null) {
        $con = curl_init((string)$url);
        curl_setopt($con, CURLOPT_HEADER, false);
        curl_setopt($con, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($con, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($con, CURLOPT_AUTOREFERER, 1);
        if (isset($header)) {
            curl_setopt($con, CURLOPT_HTTPHEADER, $header);
        }
        if (isset($data)) {
            curl_setopt($con, CURLOPT_POST, true);
            curl_setopt($con, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($con, CURLOPT_TIMEOUT, 5000);
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

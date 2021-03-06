<?php
/**
 * Created by PhpStorm.
 * User: knowthis
 * Date: 15/11/4
 * Time: 下午5:31
 */
include('config/config.php');

$sql_info = "select bi_name,bi_img,bi_num from blog_info ";
$re_info =  mysqli_query($conn, $sql_info);
$row_info = mysqli_fetch_array($re_info);
$person_data= array(
    'personPic'=>$row_info['bi_img'],
    'personName' => $row_info['bi_name']
);

//导航数据
$sql_nav = "select id,bn_name,bn_link from blog_nav where bn_show=1 order by bn_index asc ";
$re_nav =  mysqli_query($conn, $sql_nav);
$nav_data = [];
while($row_nav  = mysqli_fetch_array($re_nav))
{
    $nav_data[] = array(
        "id" => $row_nav['id'],
        "link" => $row_nav['bn_link'],
        "text" => $row_nav['bn_name']
    );
}

//分享数据
$sql_share = "select id,bs_code,bs_link from blog_share where bs_show=1 order by bs_index asc ";
$re_share=  mysqli_query($conn, $sql_share);
$share_data = [];
while($row_share = mysqli_fetch_array($re_share))
{
    $share_data[] = array(
        "id" => $row_share['id'],
        "link" => $row_share['bs_link'],
        "text" => $row_share['bs_code']
    );
}

//新闻数据
$sql_news = "select * from blog_project where bp_show=1 order by id asc limit 20 ";
$re_news=  mysqli_query($conn, $sql_news);
$news_data = [];
while($row_news = mysqli_fetch_array($re_news))
{
    $news_content = mb_strlen($row_news['bp_content'])>200?$row_news['bp_content']."...":$row_news['bp_content'];
    $news_data[] = array(
        "id" => $row_news['id'],
        "projectPic" => $row_news['bp_pic'],
        "projectTitle"=> $row_news['bp_title'],
        "projectCreateTime"=> $row_news['bp_createTime'],
        "projectAuthor" => $row_news['bp_author'],
        "projectURL"=> $row_news['bp_url'],
        "projectGITHUB" => $row_news['bp_github'],
        "projectContent" => mb_substr(strip_tags($news_content), 0, 200, 'utf-8')
    );
}


$data = array(
    "Data" => array(
        "personInfo"=> $person_data,
        "list" => $nav_data,
        "copyright"=> array(
            "copyInfo"=> $row_info['bi_name'],
            "copyNum"=> $row_info['bi_num'],
            "share"=> $share_data
        )
    ),
    "rightDate"=> array(
        "project"=> $news_data
    )

);
echo json_encode($data);


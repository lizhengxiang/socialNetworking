function Ips() {
    /**
     * 数据加载器
     *
     * @param  {[type]}   module     模块名，为空默认当前index。
     * @param  {[type]}   method     方法名，为空默认当前index。
     * @param  {[type]}   params     传给服务器数据，和$.ajax.data规则一样。
     * @param  {Function} callback   成功时的回调函数，不设置则使用阻塞模式，否则使用异步
     * @param  {[type]}   onerror    异常处理回调函数，不设置则使用默认提示
     * @param  {[type]}   remote     强制决定是否使用远程模式
     * @param  {[type]}   cached     是否使用客户端缓存，默认为false
     * @param  {[type]}   expiration 缓存失效时间，单位秒，默认为0不失效
     * @param  {[type]}   beforesend [description]
     * @this   {this}   this
     *
     * @return {[type]}              [description]
     */
    this.load = function(
        module, method, params, callback) {
        module = module || 'index';
        method = method || 'index';
        params = params || {};
        callback = callback || false;
        var self = this,
            result = false;

        var purl ='data/' + module + '/' + method + '.dat';
        console.log(purl);
        if (remote) {
            purl = this.options.apiurl;
            if (purl.indexOf('?') > -1)
                purl += '&';
            else
                purl += '?';
            purl += 't=json&m=' + module + '&f=' + method;
        }
        $.ajax({
            async: callback ? true : false,
            type: 'POST',
            url: purl,
            data: params,
            processData: true,
            datatype: 'json',
            beforeSend: function(XMLHttpRequest) {
                if (beforesend)
                    beforesend();
            },
            success: function(json) {
                if (typeof json === 'string') {
                    if (json.length < 1) {
                        $ips.unLockPage();
                        self.showError(2, ['json无效，数据为空']);
                        return;
                    }
                    try {
                        result = eval('(' + json + ')');
                    } catch (e) {
                        if (typeof console.log != 'undefined') {
                            console.log(json);
                        }
                        self.showError(2, ['服务器返回数据无法解析']);
                        sendMessageToGateway({
                            'HttpError': 500
                        });
                        return false;
                    }
                } else {
                    result = json;
                }

                // 解包
                if (result != null && result.code != 0) {
                    $ips.unLockPage();
                    if (onerror)
                        onerror(result);
                    else
                        self.showError(result.code, [result.message]);
                    result = false;
                } else {
                    //if (result.data) {
                    // 如果是page，则解包
                    // if (result.jsonh == 1 && $.isArray(result.data))
                    // {
                    // result.data = JSONH.unpack(result.data);
                    // } else if (result.data.jsonh == 1 &&
                    // $.isArray(result.data.result)) {
                    // result.data.result =
                    // JSONH.unpack(result.data.result);
                    // }
                    //}
                    if (callback)
                        callback(result.data);
                    // 缓存数据
                    if (cached)
                        self.cachePut(key, result.data, expiration);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                try {
                    if (window.top != window) {
                        if (XMLHttpRequest.status == 401) {
                            self.loadDataStatus = 401;
                            renderLoginToken();
                            return false;
                        } else {
                            if (typeof self.loadDataStatus != 'undefined' &&
                                self.loadDataStatus == 401) {
                                self.alert('正在验证登录状态...');
                                return false;
                            }
                            sendMessageToGateway({
                                'HttpError': XMLHttpRequest.status
                            });
                        }
                    }

                    if (callback)
                        callback(null);
                    self.showError(2, [textStatus + ' ' + errorThrown]);
                } catch (e) {}
            }
        });
        return result ? result.data : result;
    };
    
}

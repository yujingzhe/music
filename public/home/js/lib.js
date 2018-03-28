(function() {
        lib = {
                s_earch:function(kid) {
                        var keyword = document.getElementById(kid).value.replace(/\//g, "");
                        keyword = keyword.replace(/\\/g, "");
                        keyword = keyword.replace(/\?/g, "");
                        var _url = search_url.replace(/target/g, keyword);
                        if (keyword == "" || keyword == "�ҵ�������") {
                                lib.t_ips("������Ҫ���ҵĹؼ��ʣ�", 0, 3e3);
                                document.getElementById(kid).focus();
                                return;
                        } else {
                                location.href = _url;
                        }
                },
                quanxuan:function(obj) {
                        with (document.getElementById(obj)) {
                                var ins = getElementsByTagName("input");
                                for (var i = 0; i < ins.length; i++) {
                                        ins[i].checked = !ins[i].checked;
                                }
                        }
                },
                t_ips:function(text, type, time) {
                        var top = document.body.scrollTop + document.documentElement.scrollTop + 300;
                        document.getElementById("error_tips").style.top = top + "px";
                        document.getElementById("error_tips").style.display = "";
                        document.getElementById("error_tips_content").style.background = type ? "#0dad51" :"#525c5f";
                        document.getElementById("error_message").innerHTML = text;
                        setTimeout("document.getElementById('error_tips').style.display = 'none';", time);
                },
                s_onblur:function() {
                        setTimeout("document.getElementById('getsearch').style.display = 'none';", 500);
                }
        };
})();
function createXMLHttpRequest() {
	try {
		XMLHttpReq = new ActiveXObject('Msxml2.XMLHTTP');
	} catch(e) {
		try {
			XMLHttpReq = new ActiveXObject('Microsoft.XMLHTTP');
		} catch(e) {
			XMLHttpReq = new XMLHttpRequest();
		}
	}
}
function getHttpObject() {
        var objType = false;
        try {
                objType = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
                try {
                        objType = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                        objType = new XMLHttpRequest();
                }
        }
        return objType;
}
function get_search(key) {
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {
                processAJAX();
        };
        theHttpRequest.open("GET", temp_url + "source/ajax_search.php?key=" + escape(key), true);
        theHttpRequest.send(null);
        function processAJAX() {
                if (theHttpRequest.readyState == 4) {
                        if (theHttpRequest.status == 200) {
                                document.getElementById("getsearch").innerHTML = theHttpRequest.responseText;
                        } else {
                                document.getElementById("getsearch").innerHTML = "�����쳣...";
                        }
                        document.getElementById("getsearch").style.display = "";
                }
        }
}
function get_player(_ids, _fid) {
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {
                processAJAX();
        };
        theHttpRequest.open("GET", temp_url + "source/ajax_player.php?type=get&id=" + _ids + "&fid=" + _fid, true);
        theHttpRequest.send(null);
        function processAJAX() {
                if (theHttpRequest.readyState == 4) {
                        if (theHttpRequest.status == 200) {
                                document.getElementById("jp-playlist-box").innerHTML = theHttpRequest.responseText;
                        } else {
                                document.getElementById("jp-playlist-box").innerHTML = "�����쳣...";
                        }
                }
        }
}
function get_login() {
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {
                processAJAX();
        };
        theHttpRequest.open("GET", temp_url + "source/ajax_login.php", true);
        theHttpRequest.send(null);
        function processAJAX() {
                if (theHttpRequest.readyState == 4) {
                        if (theHttpRequest.status == 200) {
                                document.getElementById("getlogin").innerHTML = theHttpRequest.responseText;
                        } else {
                                document.getElementById("getlogin").innerHTML = "�����쳣...";
                        }
                }
        }
}
function get_info() {
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {
                processAJAX();
        };
        theHttpRequest.open("GET", temp_url + "source/ajax_info.php", true);
        theHttpRequest.send(null);
        function processAJAX() {
                if (theHttpRequest.readyState == 4) {
                        if (theHttpRequest.status == 200) {
                                document.getElementById("getinfo").innerHTML = theHttpRequest.responseText;
                        } else {
                                document.getElementById("getinfo").innerHTML = "�����쳣...";
                        }
                }
        }
}
function get_comment(_id, _pid) {
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {
                processAJAX();
        };
        theHttpRequest.open("GET", temp_url + "source/ajax_comment.php?id=" + _id + "&pid=" + _pid, true);
        theHttpRequest.send(null);
        function processAJAX() {
                if (theHttpRequest.readyState == 4) {
                        if (theHttpRequest.status == 200) {
                                document.getElementById("comment_tab").innerHTML = theHttpRequest.responseText;
                        } else {
                                document.getElementById("comment_tab").innerHTML = "�����쳣...";
                        }
                }
        }
}
function get_like(_id) {
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {
                processAJAX();
        };
        theHttpRequest.open("GET", temp_url + "source/ajax_like.php?ac=get&id=" + _id, true);
        theHttpRequest.send(null);
        function processAJAX() {
                if (theHttpRequest.readyState == 4) {
                        if (theHttpRequest.status == 200) {
                                document.getElementById("like").innerHTML = theHttpRequest.responseText;
                        } else {
                                document.getElementById("like").innerHTML = "�����쳣...";
                        }
                }
        }
}
function create_like(_id, _do) {
        createXMLHttpRequest();
        XMLHttpReq.open("GET", temp_url + "source/ajax_like.php?ac=create&id=" + _id + "&do=" + _do, true);
        XMLHttpReq.onreadystatechange = function() {
                if (XMLHttpReq.readyState == 4) {
                        if (XMLHttpReq.status == 200) {
                                if (XMLHttpReq.responseText == "return_1") {
                                        lib.t_ips("���ֲ����ڻ��ѱ�ɾ����", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_2") {
                                        lib.t_ips("���ո��Ѿ����۹��ˣ�", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_3") {
                                        lib.t_ips("��ϲ�����Ѿ����۳ɹ���", 1, 1e3);
                                } else {
                                        lib.t_ips("�ڲ����ִ������Ժ����ԣ�", 0, 3e3);
                                }
                                get_like(_id);
                        } else {
                                lib.t_ips("ͨѶ�쳣�������������ã�", 0, 3e3);
                        }
                }
        };
        XMLHttpReq.send(null);
}
function create_fav(_id) {
        createXMLHttpRequest();
        XMLHttpReq.open("GET", temp_url + "source/ajax.php?ac=fav&id=" + _id, true);
        XMLHttpReq.onreadystatechange = function() {
                if (XMLHttpReq.readyState == 4) {
                        if (XMLHttpReq.status == 200) {
                                if (XMLHttpReq.responseText == "return_0") {
                                        lib.t_ips("���ȵ�¼�û����ģ�", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_1") {
                                        lib.t_ips("���ֲ����ڻ��ѱ�ɾ����", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_2") {
                                        lib.t_ips("��ϲ�������ղسɹ���", 1, 1e3);
                                } else {
                                        lib.t_ips("�ڲ����ִ������Ժ����ԣ�", 0, 3e3);
                                }
                        } else {
                                lib.t_ips("ͨѶ�쳣�������������ã�", 0, 3e3);
                        }
                }
        };
        XMLHttpReq.send(null);
}
function create_down(_id) {
        createXMLHttpRequest();
        XMLHttpReq.open("GET", temp_url + "source/ajax.php?ac=down&id=" + _id, true);
        XMLHttpReq.onreadystatechange = function() {
                if (XMLHttpReq.readyState == 4) {
                        if (XMLHttpReq.status == 200) {
                                if (XMLHttpReq.responseText == "return_0") {
                                        lib.t_ips("���ȵ�¼�û����ģ�", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_1") {
                                        lib.t_ips("Ȩ�޲������뿪ͨ���꣡", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_2") {
                                        lib.t_ips("��Ҳ��㣬���ȳ�ֵ��", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_3") {
                                        lib.t_ips("���ֲ����ڻ��ѱ�ɾ����", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_4") {
                                        location.href = temp_url + "source/audio.php?id=" + _id;
                                } else {
                                        lib.t_ips("�ڲ����ִ������Ժ����ԣ�", 0, 3e3);
                                }
                        } else {
                                lib.t_ips("ͨѶ�쳣�������������ã�", 0, 3e3);
                        }
                }
        };
        XMLHttpReq.send(null);
}
function uc_syn(type) {
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {
                processAJAX();
        };
        theHttpRequest.open("GET", in_path + "source/user/people/syn.php?uc=" + type, true);
        theHttpRequest.send(null);
        function processAJAX() {
                if (theHttpRequest.readyState == 4) {
                        if (theHttpRequest.status == 200) {
				var src = theHttpRequest.responseText.match(/src=".*?"/g);
				if (src) {
					for (i = 0; i < src.length; i++) {
						var ucenter = document.createElement("script");
						ucenter.type = "text/javascript";
						ucenter.src = src[i].match(/src="([^"]*)"/)[1];
						document.getElementsByTagName("head")[0].appendChild(ucenter);
					}
				}
                        }
                }
        }
}
function logout() {
        createXMLHttpRequest();
        XMLHttpReq.open("GET", temp_url + "source/ajax.php?ac=logout", true);
        XMLHttpReq.onreadystatechange = processResponse;
        XMLHttpReq.send(null);
}
function processResponse() {
        if (XMLHttpReq.readyState == 4) {
                if (XMLHttpReq.status == 200) {
                        var tips = XMLHttpReq.responseText;
                        if (tips == "return_0") {
                                lib.t_ips("�ʼ���������δ����������ϵ����Ա��", 0, 3e3);
                        } else if (tips == "return_1") {
                                lib.t_ips("��֤�벻��ȷ������ģ�", 0, 3e3);
                        } else if (tips == "return_5") {
                                uc_syn("login");
                                lib.t_ips("��ϲ�����Ѿ��ɹ������ʺţ�", 1, 1e3);
                                setTimeout("parent.location.href='" + in_path + "';", 1e3);
                        } else if (tips == "return_6") {
                                lib.t_ips("��Ǹ�������ʺ��Ѿ���������", 0, 3e3);
                        } else if (tips == "return_9") {
                                uc_syn("login");
                                lib.t_ips("��ϲ�����Ѿ��ɹ���¼��վ��", 1, 1e3);
                                setTimeout("parent.location.href='" + in_path + "';", 1e3);
                        } else if (tips == "return_10") {
                                lib.t_ips("�ʺŻ�������������ԣ�", 0, 3e3);
                        } else if (tips == "return_11") {
                                lib.t_ips("�û����Ѿ���ע�ᣬ�����һ����", 0, 3e3);
                        } else if (tips == "return_12") {
                                lib.t_ips("�����Ѿ���ռ�ã������һ����", 0, 3e3);
                        } else if (tips == "return_13") {
                                lib.t_ips("UCenter API: �û������Ϸ���", 0, 3e3);
                        } else if (tips == "return_14") {
                                lib.t_ips("UCenter API: ����������ע��Ĵ��", 0, 3e3);
                        } else if (tips == "return_15") {
                                lib.t_ips("UCenter API: �û����Ѿ����ڣ�", 0, 3e3);
                        } else if (tips == "return_16") {
                                lib.t_ips("UCenter API: Email ��ʽ����", 0, 3e3);
                        } else if (tips == "return_17") {
                                lib.t_ips("UCenter API: Email ������ע�ᣡ", 0, 3e3);
                        } else if (tips == "return_18") {
                                lib.t_ips("UCenter API: Email �Ѿ���ע�ᣡ", 0, 3e3);
                        } else if (tips == "return_19") {
                                lib.t_ips("UCenter API: ����δ���壡", 0, 3e3);
                        } else if (tips == "return_20") {
                                lib.t_ips("��ϲ�����Ѿ��ɹ�ע���ʺţ�", 1, 1e3);
                                setTimeout("location.href='" + in_path + "';", 1e3);
                        } else if (tips == "return_21") {
                                lib.t_ips("�û��������ڣ���������ԣ�", 0, 3e3);
                        } else if (tips == "return_22") {
                                lib.t_ips("��֤��Ϣ��ƥ�䣬�����ԣ�", 0, 3e3);
                        } else if (tips == "return_23") {
                                lostpasswd(2);
                        } else if (tips == "logout") {
                                uc_syn("logout");
                                get_login();
                                lib.t_ips("���Ѿ���ȫ�˳��ˣ�", 1, 1e3);
                        } else {
                                lib.t_ips("�ڲ����ִ������Ժ����ԣ�", 0, 3e3);
                        }
                } else {
                        lib.t_ips("ͨѶ�쳣�������������ã�", 0, 3e3);
                }
        }
}
function login(type) {
        var username = document.getElementById("username");
        var password = document.getElementById("password");
        var seccode = document.getElementById("seccode");
        if (strLen(username.value) < 1) {
                lib.t_ips("�û�������Ϊ�գ�", 0, 3e3);
                username.focus();
                return;
        } else if (strLen(password.value) < 1) {
                lib.t_ips("���벻��Ϊ�գ�", 0, 3e3);
                password.focus();
                return;
        } else if (strLen(seccode.value) != 4) {
                lib.t_ips("��������λ��֤�룡", 0, 3e3);
                seccode.focus();
                return;
        }
        createXMLHttpRequest();
        XMLHttpReq.open("GET", in_path + "source/user/people/ajax.php?ac=login&qq=" + type + "&name=" + escape(username.value) + "&pwd=" + escape(password.value) + "&code=" + seccode.value, true);
        XMLHttpReq.onreadystatechange = processResponse;
        XMLHttpReq.send(null);
}
function register() {
        var username = document.getElementById("username");
        if (strLen(username.value) < 3 || strLen(username.value) > 15 || !/^([\S])*$/.test(username.value) || !/^([^<>'"\/\\])*$/.test(username.value)) {
                document.getElementById("username_tips").innerHTML = "<i>�� 3 �� 15 ���ַ���ɣ������пո�� < > ' \" / \\ ���ַ���</i>";
                username.focus();
                return;
        } else {
                document.getElementById("username_tips").innerHTML = "";
        }
        var password = document.getElementById("password");
        if (strLen(password.value) < 6) {
                document.getElementById("password_tips").innerHTML = "<i>��С����Ϊ 6 ���ַ���</i>";
                password.focus();
                return;
        } else {
                document.getElementById("password_tips").innerHTML = "";
        }
        var password1 = document.getElementById("password1");
        if (password1.value !== password.value) {
                document.getElementById("password1_tips").innerHTML = "<i>������������벻һ�£�</i>";
                password1.focus();
                return;
        } else {
                document.getElementById("password1_tips").innerHTML = "";
        }
        var mail = document.getElementById("mail");
        if (strLen(mail.value) < 1 || isEmail(mail.value) == false) {
                document.getElementById("mail_tips").innerHTML = "<i>��д�� Email ��ʽ����</i>";
                mail.focus();
                return;
        } else {
                document.getElementById("mail_tips").innerHTML = "";
        }
        var seccode = document.getElementById("seccode");
        if (strLen(seccode.value) != 4) {
                document.getElementById("seccode_tips").innerHTML = "&nbsp;&nbsp;��������λ��֤�룡";
                seccode.focus();
                return;
        } else {
                document.getElementById("seccode_tips").innerHTML = "";
        }
        createXMLHttpRequest();
        XMLHttpReq.open("GET", in_path + "source/user/people/ajax.php?ac=register&name=" + escape(username.value) + "&pwd=" + escape(password1.value) + "&mail=" + escape(mail.value) + "&code=" + seccode.value, true);
        XMLHttpReq.onreadystatechange = processResponse;
        XMLHttpReq.send(null);
}
function lostpasswd(type) {
        if (type == 1) {
                var username = document.getElementById("username");
                if (strLen(username.value) < 1) {
                        document.getElementById("username_tips").innerHTML = "<i>�������û�����</i>";
                        username.focus();
                        return;
                } else {
                        document.getElementById("username_tips").innerHTML = "";
                }
                var mail = document.getElementById("mail");
                if (strLen(mail.value) < 1 || isEmail(mail.value) == false) {
                        document.getElementById("mail_tips").innerHTML = "<i>��д�� Email ��ʽ����</i>";
                        mail.focus();
                        return;
                } else {
                        document.getElementById("mail_tips").innerHTML = "";
                }
                var seccode = document.getElementById("seccode");
                if (strLen(seccode.value) != 4) {
                        document.getElementById("seccode_tips").innerHTML = "&nbsp;&nbsp;��������λ��֤�룡";
                        seccode.focus();
                        return;
                } else {
                        document.getElementById("seccode_tips").innerHTML = "";
                }
                createXMLHttpRequest();
                XMLHttpReq.open("GET", in_path + "source/user/people/ajax.php?ac=lostpasswd&type=1&name=" + escape(username.value) + "&mail=" + escape(mail.value) + "&code=" + seccode.value, true);
                XMLHttpReq.onreadystatechange = processResponse;
                XMLHttpReq.send(null);
        } else if (type == 2) {
                createXMLHttpRequest();
                XMLHttpReq.open("GET", in_path + "source/user/people/ajax.php?ac=lostpasswd&type=2", true);
                XMLHttpReq.onreadystatechange = function() {
                        if (XMLHttpReq.readyState == 4) {
                                if (XMLHttpReq.status == 200) {
                                        if (XMLHttpReq.responseText == "return_26") {
                                                lib.t_ips("�ʼ��Ѿ���������ȴ� 30 ���ſ����·��ͣ�", 0, 3e3);
                                        } else if (XMLHttpReq.responseText == "return_28") {
                                                lib.t_ips("��ϲ���ʼ��Ѿ����ͳɹ���", 1, 1e3);
                                        } else {
                                                lib.t_ips("��Ǹ���ʼ�δ�ܷ��ͳɹ���", 0, 3e3);
                                        }
                                } else {
                                        lib.t_ips("ͨѶ�쳣�������������ã�", 0, 3e3);
                                }
                        }
                };
                XMLHttpReq.send(null);
        }
}
function send_comment(_id) {
        var _content = document.getElementById("_content").value;
        if (strLen(_content) < 6) {
                document.getElementById("_tips").innerHTML = "������������<em>6</em>���ַ���";
                return;
        } else if (strLen(_content) > 128) {
                document.getElementById("_tips").innerHTML = "�����������<em>128</em>���ַ���";
                return;
        } else {
                document.getElementById("_tips").innerHTML = "��<em>����</em>���ԣ�";
        }
        createXMLHttpRequest();
        XMLHttpReq.open("GET", temp_url + "source/ajax.php?ac=comment&id=" + _id + "&content=" + escape(_content), true);
        XMLHttpReq.onreadystatechange = function() {
                if (XMLHttpReq.readyState == 4) {
                        if (XMLHttpReq.status == 200) {
                                if (XMLHttpReq.responseText == "return_0") {
                                        lib.t_ips("���ȵ�¼�û����ģ�", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_1") {
                                        lib.t_ips("���ֲ����ڻ��ѱ�ɾ����", 0, 3e3);
                                } else if (XMLHttpReq.responseText == "return_2") {
                                        document.getElementById("_tips").innerHTML = "ÿ�����ۼ��ʱ��Ϊ<em>30</em>�룡";
                                } else if (XMLHttpReq.responseText == "return_3") {
                                        get_comment(_id, 1);
                                        lib.t_ips("��ϲ�����۷���ɹ���", 1, 1e3);
                                } else {
                                        lib.t_ips("�ڲ����ִ������Ժ����ԣ�", 0, 3e3);
                                }
                        } else {
                                lib.t_ips("ͨѶ�쳣�������������ã�", 0, 3e3);
                        }
                }
        };
        XMLHttpReq.send(null);
}
function strLen(str) {
        var charset = document.charset;
        var len = 0;
        for (var i = 0; i < str.length; i++) {
                len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? charset == "gbk" ? 3 :2 :1;
        }
        return len;
}
function isEmail(input) {
        if (input.match(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/)) {
                return true;
        }
        return false;
}
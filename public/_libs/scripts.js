
//ИНИЦИАЛИЗАЦИЯ РЕДАКТОРА HTML
function nicEditorInit()
{
	t=$('.textareaHtml');
	for(i=0;i<t.length;i++)
		new nicEditor({ 
			fullPanel : true
		}).panelInstance(t[i].id); 

	$('.nicEdit-main').each(function () {
		let $this = $(this);
		let htmlOld = $this.html();
		$this.bind('blur paste copy cut mouseup', function () {
			let htmlNew = $this.html();
			if (htmlOld !== htmlNew) {
				this.parentElement.nextElementSibling.value = htmlNew;
				this.parentElement.nextElementSibling.onchange();
				htmlOld = htmlNew;
			}
		});
	});
}
//КОНЕЦ ИНИЦИАЛИЗАЦИЯ РЕДАКТОРА HTML


/*МОДАЛЬНОЕ ОКНО*/
function openModalWindowHTMLContent(content, params = {}, config = {}) {
	win = document.getElementById('modalWinTemplate').cloneNode(true);
	if (config['class'])
		$(win).addClass(config['class']);

	if(config['noClose']){
		win.onclick='';
		$(win).find('.pop_up_win_close_button').hide();
	}

	if (params['listRootElClass'])
		$(win).data('listRootElClass', params['listRootElClass']);
	if (params['id'])
		$(win).data('id', params['id']);

	win.id = 'modalWin' + Math.random();
	$(win).find('.pop_up_content').html(content);
	nodeScriptReplace(win);
	$(win).hide();
	document.body.append(win);
	$(win).fadeIn(200);
	document.body.classList.add('bodyHasActiveModalWin');
	win.addEventListener("touchstart", function(e) {if(e.touches.length>1)  e.preventDefault();}, false);
	if (typeof (afterCardTabContentLoad) != 'undefined')
		afterCardTabContentLoad();
}
function openModalWindowAndLoadContent(url, params = {}, config = {}) {
	params['_token'] = _token;
	params['responseType'] = 'json';
	fetch(url + '?' + (new URLSearchParams(params).toString()), {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		},
	})
	.then(response => response.json())
	.then(data => {
		if (data.success !== 1) {
			console.log(data.error);
			alert('Ошибка открытия окна');
		}
		else {
			openModalWindowHTMLContent(data.blockContent, params , config);
			
		}
	});
	if(typeof (hideMainMenu) != 'undefined')
		hideMainMenu();
}

function closeModalWindow(el, callBack = function(){}) {
	let win = findAncestorByClassName(el, 'pop_up_win');
	if (win)
		$(win).fadeOut(200, function () { win.remove(); });
	else
		console.log('Окно не найдено (класс pop_up_win)');

	if (typeof (updateListRow) != "undefined" && $(win).data('id') && $(win).data('listRootElClass'))
		setTimeout(() => { updateListRow($(win).data('listRootElClass'), $(win).data('id')); }, 500);

	if($('.pop_up_win:visible').length <= 1)
		document.body.classList.remove('bodyHasActiveModalWin');

	callBack();

	if (typeof (afterCloseModalWindow) != "undefined")
		setTimeout(() => { afterCloseModalWindow(); }, 500);
}
/*КОНЕЦ МОДАЛЬНОЕ ОКНО*/


/*АКТИВАЦИЯ СКРИПТОВ ИЗ ВСТАВЛЯЕМОГО КОНТАНТА*/
function nodeScriptReplace(node) {
	if (nodeScriptIs(node) === true) {
		node.parentNode.replaceChild(nodeScriptClone(node), node);
	}
	else {
		var i = -1, children = node.childNodes;
		while (++i < children.length) {
			nodeScriptReplace(children[i]);
		}
	}
	return node;
}
function nodeScriptClone(node) {
	var script = document.createElement("script");
	script.text = node.innerHTML;

	var i = -1, attrs = node.attributes, attr;
	while (++i < attrs.length) {
		script.setAttribute((attr = attrs[i]).name, attr.value);
	}
	return script;
}

function nodeScriptIs(node) {
	return node.tagName === 'SCRIPT';
}
/*КОНЕЦ АКТИВАЦИЯ СКРИПТОВ ИЗ ВСТАВЛЯЕМОГО КОНТАНТА*/

//НАЙТИ РОДИТЕЛЯ ПО КЛАССУ
function findAncestorByClassName(el, cls) {
	if (el.classList && el.classList.contains(cls)) return el;
	while ((el = el.parentElement) && !el.classList.contains(cls));
	return el;
}



function saveUserCard(userId, projectId=null)
{
	let data = {
		'userId': userId,
		'projectId': projectId,
		'phone': $('.userCardRoot'+userId+' .userCardPhone').val(),
		'image': $('.userCardRoot'+userId+' .userCardImage').val(),
		'name1': $('.userCardRoot'+userId+' .userCardName1').val(),
		'name2': $('.userCardRoot'+userId+' .userCardName2').val(),
		'name3': $('.userCardRoot'+userId+' .userCardName3').val(),
		'nameEn1': $('.userCardRoot'+userId+' .userCardNameEn1').val(),
		'nameEn2': $('.userCardRoot'+userId+' .userCardNameEn2').val(),
		'gender': $('.userCardRoot'+userId+' input[name="gender"]').prop('checked') ? 1 : 0,
		'participationType': $('.userCardRoot'+userId+' input[name="participationType"]').prop('checked') ? 1 : 0,
		'_token': _token,
	};
	if($('.userCardRoot'+userId+' input[name="autoApprove"]').length>0)
		data['autoApprove'] = $('.userCardRoot'+userId+' input[name="autoApprove"]').prop('checked') ? 1 : 0;
	if($('.userCardRoot'+userId+' textarea[name="descr"]').length>0)
		data['descr'] = $('.userCardRoot'+userId+' textarea[name="descr"]').val();
	if($('.userCardRoot'+userId+' input[name="admin"]').length>0)
		data['admin'] = $('.userCardRoot'+userId+' input[name="admin"]').prop('checked') ? 1 : 0;
	if($('.userCardRoot'+userId+' input[name="tamada"]').length>0)
		data['tamada'] = $('.userCardRoot'+userId+' input[name="tamada"]').prop('checked') ? 1 : 0;

	if($('.userCardRoot'+userId+' .userCardTags').length>0){
		var tags = [];
		var tagFields = $('.userCardTags tag');
		for(i=0; i<tagFields.length; i++){
			tags[tags.length] = tagFields[i].attributes.value.value;
		}
		data['tags'] = tags;
	}
	fetch('/user/save', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
		},
		body: JSON.stringify(data),
	})
	.then(response => response.json())
	.then(data => {
		updateProjectRegisterSector();
		if (data.success !== 1){
			alert(data.error);
			return;
		}
		closeModalWindow($('.userCardRoot'+userId)[0]);
	});
}


function addElement(url_action, root_field = null, root_id = null, cnt = null, reload = false, callback = null)
{
	if(cnt==null)
		cnt=parseInt(prompt('Сколько элементов добавить?', 1));

	if(cnt>0)
	{
		let data = {
			'cnt': cnt,
			'root_field': root_field,
			'root_id': root_id,
			'_token': _token,
		};
		fetch(url_action, {
			method: 'POST',
			headers: {'Content-Type': 'application/json'},
			body: JSON.stringify(data),
		})
		.then(response => response.json())
		.then(data => {
			if(data.success!=1)
				alert("Ошибка: "+data.error);
			if(reload == true)
			{
				document.location.reload();
				/*var url = new URL(document.location.href);
				var scrollTop = $('#adminBlockContent').scrollTop();
				if(scrollTop)
					url.searchParams.set('scrollTop', scrollTop);
				document.location.href = url.toString();*/
			}
			if(callback)
				callback(data);
		});
	}
	return false;
}

function deleteElement(url_action, id, reload = false, callback = null)
{
	if(!confirm('Удалить элемент?'))
		return;

	let data = {
		'id': id,
		'_token': _token,
	};
	fetch(url_action, {
		method: 'POST',
		headers: {'Content-Type': 'application/json'},
		body: JSON.stringify(data),
	})
	.then(response => response.json())
	.then(data => {
		if(data.success!=1)
			alert("Ошибка: "+data.error);
		if(reload == true){
		//	document.location.reload();
			var url = new URL(document.location.href);
			var scrollTop = $('#adminBlockContent').scrollTop();
			if(scrollTop)
				url.searchParams.set('scrollTop', scrollTop);
			document.location.href = url.toString();
		}
		if(callback)
			callback(data);
	});
	/*e.preventDefault();
	e.stopPropagation();*/
}

function uploadPhotos(type, elId, elButton) {
	let rootEl = $('.photoViewer' + type + elId);
	rootEl.find('.photoViewerUploadResult').text("");
	$(elButton).hide();

	let data = new FormData();
	data.append('type', type);
	data.append('elId', elId);
	data.append('_token', _token);
	for (file of rootEl.find('input[type=file]')[0].files) {
		data.append(file.name, file)
	}

	fetch('/photo/upload', {
		method: 'POST',
		body: data
	})
	.then(response => response.json())
	.then(data => {
		$(elButton).show();
		if (data.success != 1)
			rootEl.find('.photoViewerUploadResult').text(data.error);
		else {
			rootEl.find('input[type=file]').val(null);
			let tmp = '';
			if(data.files.length>0) 
				tmp += '<div style="color:green;">Загружено фотографий: '+data.files.length+'</div>';
			if(data.errors.length>0) {
				tmp += '<div style="color:red;">Ошибки: ';
				for(i in data.errors)
					tmp += '<div>'+data.errors[i]+'</div>';

				tmp += '</div>';
			}

			rootEl.find('.photoViewerUploadResult').html(tmp);
		}
	})
	.catch(error => {
		$(elButton).show();
	});
}

function deletePhoto(photoId)
{
	if(!confirm('Удалить фотографию?')) 
		return;
	let data = {
		'photoId': photoId,
		'_token': _token,
	};
	fetch('/photo/delete', {
		method: 'POST',
		headers: {'Content-Type': 'application/json'},
		body: JSON.stringify(data),
	})
	.then(response => response.json())
	.then(data => {
		if(data.success!=1)
			alert("Ошибка: "+data.error);
		else
			$('.photoDiv'+photoId).remove();
	});
}

function getCertificate(url)
{
	window.open("/certificate/file?uuid="+url);
}



function openLoginForm()
{
	openModalWindowAndLoadContent("/user/getLoginForm", {}, {'class': 'loginFormWin'});
}

var prevPhone = [null, null];
function onPhoneChange(phoneEl, type = 0){
	var phone = getPhone(phoneEl);
	if(prevPhone != phone)
	{
		if(type==0){
			$('.loginFormCorrectPhoneRoot').hide();
			$('.loginFormButtonCheckPhone').text('Отправить код');
			$('.loginFormButtonCheckPhone').show();
		}
		if(type==1)
			$('.projectContentRegisterButtonCheckPhone').show();
	}
	prevPhone = phone;
	if(!phone || phone.substr(0, 1)=="7" && phone.length != 11 || phone.length < 8)
	{
		if(type==0)
			$('.loginFormButtonCheckPhone').addClass('buttonDisabled');
		if(type==1)
			$('.projectContentRegisterButtonCheckPhone').addClass('buttonDisabled');
	}
	else
	{
		if(type==0)
			$('.loginFormButtonCheckPhone').removeClass('buttonDisabled');
		if(type==1)
			$('.projectContentRegisterButtonCheckPhone').removeClass('buttonDisabled');
	}
}
function getPhone(phoneEl)
{
	var numberPattern = /\d+/g;
	return phoneEl.val().match( numberPattern ).join('');
}

function sendLoginCode(elButton, phoneEl, type=0)
{
	if($(elButton).hasClass('buttonDisabled'))
		return;

	$(elButton).addClass('buttonDisabled').text('Отправить код повторно');
	setTimeout(function() { $(elButton).removeClass('buttonDisabled'); }, 10000);

	let data = {
		'phone': getPhone(phoneEl),
		'_token': _token,
	};
	fetch('/user/sendLoginCode', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
		},
		body: JSON.stringify(data),
	})
	.then(response => response.json())
	.then(data => {
		if (data.success !== 1){
			console.log(data.error);
			return;
		}
	});
	if(type==0){
		$('.loginFormCorrectPhoneRoot').show();
		$('.loginFormLoginCode').focus()
	}
	if(type==1){
		$('.projectContentRegisterCorrectPhoneRoot').show();
		$('.projectContentRegisterLoginCode').focus()
	}
}

function checkLoginCode(elButton, phoneEl, codeEl, type=0)
{
	if($(elButton).hasClass('buttonDisabled'))
		return;

	let data = {
		'phone': getPhone(phoneEl),
		'code': codeEl.val(),
		'_token': _token,
	};
	fetch('/user/checkLoginCode', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
		},
		body: JSON.stringify(data),
	})
	.then(response => response.json())
	.then(data => {
		if (data.success !== 1){
			if(type==0)
				$('.loginFormButtonCheckLoginCodeError').text(data.error);
			if(type==1)
				$('.projectContentRegisterButtonCheckLoginCodeError').text(data.error);
			return;
		}
		document.location.reload();
	});
}


function openUserCard(projectId = null)
{
	openModalWindowAndLoadContent("/user/getCardEditContent", {'projectId': projectId}, {'class': 'userCardmWin'});
}


function logout()
{
	let data = {
		'_token': _token,
	};
	fetch('/user/logout', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
		},
		body: JSON.stringify(data),
	})
	.then(response => response.json())
	.then(data => {
		document.location.reload();
	});
}

/*function findPhoneForRegister(phoneEl, projectId)
{
	if($('.projectContentRegisterButtonCheckPhone').hasClass('buttonDisabled'))
		return;

	let data = {
		'projectId': projectId,
		'phone': getPhone(phoneEl),
		'_token': _token,
	};
	fetch('/projectUser/findPhoneForRegister', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
		},
		body: JSON.stringify(data),
	})
	.then(response => response.json())
	.then(data => {
		if (data.success !== 1){
			alert(data.error);
			return;
		}

		  if(data.user){
			$('.projectContentRegisterNeedAuth').show();
			if(data.projectUser){
				$('.projectContentRegisterAllreadyRegistered').show();
				$('.projectContentRegisterUserExist').hide();
			}
			else {
				$('.projectContentRegisterAllreadyRegistered').hide();
				$('.projectContentRegisterUserExist').show();
			}
		} 
		else 
		{
			$('.projectContentRegisterStep2').show();
			onRegisterFormChange();
		}
		$('.projectContentRegisterButtonCheckPhone').hide();
	});
}*/


function onRegisterFormChange()
{
	if(
		$('.projectContentRegisterStep2 .projectContentRegisterName1').val().trim().length == 0 || 
		$('.projectContentRegisterStep2 .projectContentRegisterName2').val().trim().length == 0 || 
		$('.projectContentRegisterStep2 .projectContentRegisterName3').val().trim().length == 0 || 
		$('.projectContentRegisterStep2 .projectContentRegisterNameEn1').val().trim().length == 0 || 
		$('.projectContentRegisterStep2 .projectContentRegisterNameEn2').val().trim().length == 0
	)
		$('.projectContentRegisterButtonRegister').addClass('buttonDisabled');
	else
		$('.projectContentRegisterButtonRegister').removeClass('buttonDisabled');

}

function register()
{
	if($('.projectContentRegisterButtonRegister').hasClass('buttonDisabled'))
		return;

	let data = {
		'projectId': currentProjectId,
		'phone': getPhone($(".projectContentRegisterPhone")),
		'name1': $('.projectContentRegisterStep2 .projectContentRegisterName1').val(),
		'name2': $('.projectContentRegisterStep2 .projectContentRegisterName2').val(),
		'name3': $('.projectContentRegisterStep2 .projectContentRegisterName3').val(),
		'nameEn1': $('.projectContentRegisterStep2 .projectContentRegisterNameEn1').val(),
		'nameEn2': $('.projectContentRegisterStep2 .projectContentRegisterNameEn2').val(),
		'gender': $('.projectContentRegisterStep2 input[name="gender"]').prop('checked') ? 1 : 0,
		'participationType': $('.projectContentRegisterStep2 input[name="participationType"]').prop('checked') ? 1 : 0,
		'_token': _token,
	};
	fetch('/projectUser/register', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
		},
		body: JSON.stringify(data),
	})
	.then(response => response.json())
	.then(data => {
		if (data.success !== 1){
			$('.projectContentRegisterError').text(data.error).show();
			return;
		}
		loadProject(currentProjectId, 'projectRegisterRoot');
	});
}

function deleteRegistration()
{
	if(!confirm('Вы действительно хотите удалить заявку?'))
		return;

	let data = {
		'projectId': currentProjectId,
		'_token': _token,
	};
	fetch('/projectUser/delete', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
		},
		body: JSON.stringify(data),
	})
	.then(response => response.json())
	.then(data => {
		if (data.success !== 1){
			alert(data.error);
			return;
		}
		loadProject(currentProjectId, 'projectRegisterRoot');
	});
}

function updateProjectRegisterSector()
{
	if(!currentProjectId) 
		return;
	let data = {
		'projectId': currentProjectId,
		'_token': _token,
	};
	fetch('/project/getProjectRegisterSectorContent', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
		},
		body: JSON.stringify(data),
	})
	.then(response => response.json())
	.then(data => {
		if (data.success !== 1){
			alert(data.error);
			return;
		}
		$('.projectRegisterRoot')[0].outerHTML=data.content;
	});
}
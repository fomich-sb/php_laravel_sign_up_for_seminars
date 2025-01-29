
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
	window.open("/certificate?uuid="+url);
}
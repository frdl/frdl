---
title: WORKSPACE
---

# WORKSPACE


<div>
<main>
<input id="url" type="text" placeholder="Cloud Server Address" value="https://frdl.ws/cloudsharing/">
		<input id="login" type="text" placeholder="Username or Email" value="">
		<input id="password" type="password" placeholder="password" value="">
		<input id="accessToken" type="password" placeholder="OAuth access token" value="">
		<h3>Design</h3>
		<label for="color">Main file picker color</label>
		<input id="color" type="color" value="#0082c9">
		<br>
		<label for="darkmode">Dark mode</label>
		<input id="darkmode" type="checkbox">
		<h3>Custom button which calls the "getFilesPath" method</h3>
		<button id="selectButton">My custom button to select files</button>
		<h3>Custom button which calls the "getFilesLink" method</h3>
		<button id="linkButton">My custom button to get files link</button>
		<h3>Files</h3>
		<div id="mount_point"></div>
		<hr>
		<h3>Results</h3>
		<p id="results"></p>

</main>
<!-- script src="https://npm.packages.js.api.webfan.de/nextcloud-webdav-filepicker/js/filePickerWrapper.js"></script -->
<script>
	function main() {
		const uri = window.location.search.substring(1)
		const params = new URLSearchParams(uri)
		const login = params.get('login')
		if (login) {
			document.getElementById('login').value = login
		}
		const password = params.get('password')
		if (password) {
			document.getElementById('password').value = password
		}
		const accessToken = params.get('accessToken')
		if (accessToken) {
			document.getElementById('accessToken').value = accessToken
		}
		const url = params.get('url')
		if (url) {
			document.getElementById('url').value = url
		}
		const color = params.get('color')
		if (color) {
			document.getElementById('color').value = '#' + color
		}
		const darkmode = params.get('darkMode')
		if (darkmode) {
			document.getElementById('darkmode').checked = darkmode === '1'
		}
                const initialUrl = document.getElementById('url').value
		const initialLogin = document.getElementById('login').value
		const initialPassword = document.getElementById('password').value
		const initialAccessToken = document.getElementById('accessToken').value
		const initialColor = document.getElementById('color').value
		const initialDarkMode = document.getElementById('darkmode').checked
		const filepicker = window.createFilePicker('mount_point', {
			url: initialUrl,
			login: initialLogin,
			password: initialPassword,
			accessToken: initialAccessToken,
			useCookies: false,
			themeColor: initialColor,
			darkMode: initialDarkMode,
			multipleDownload: true,
			multipleUpload: true,
			enableGetFilesPath: true,
			enableGetFilesLink: true,
			enableDownloadFiles: true,
			enableGetSaveFilePath: true,
			enableGetUploadFileLink: true,
			enableUploadFiles: true,
		})
		// monitor form value change
		document.getElementById('login').addEventListener('input', (e) => {
			filepicker.updateLogin(e.target.value)
		})
		document.getElementById('password').addEventListener('input', (e) => {
			filepicker.updatePassword(e.target.value)
		})
		document.getElementById('accessToken').addEventListener('input', (e) => {
			filepicker.updateAccessToken(e.target.value)
		})
		document.getElementById('url').addEventListener('input', (e) => {
			filepicker.updateUrl(e.target.value)
		})
		document.getElementById('color').addEventListener('change', (e) => {
			filepicker.setMainColor(e.target.value)
		})
		document.getElementById('darkmode').addEventListener('change', (e) => {
			filepicker.setDarkMode(e.target.checked)
		})
		document.getElementById('selectButton').addEventListener('click', (e) => {
			filepicker.getFilesPath()
		})
		document.getElementById('linkButton').addEventListener('click', (e) => {
			filepicker.getFilesLink({
				expirationDate: new Date('2050-01-01'),
				protectionPassword: 'example passwd',
				allowEdition: true,
				linkLabel: 'custom link label',
			})
		})
		document.addEventListener('filepicker-unauthorized', (e) => {
			console.debug('file picker got an unauthorized response')
			console.debug(e.detail)
		})
		document.addEventListener('get-files-path', (e) => {
			console.debug('no vue, received "get-files-path" event')
			console.debug(e.detail)
			const resultsP = document.getElementById('results')
			resultsP.innerHTML = 'Path of selected files:'
			e.detail.selection.forEach((path) => {
				const p = document.createElement('p')
				p.textContent = path
				resultsP.appendChild(p)
			})
		})
		document.addEventListener('get-save-file-path', (e) => {
			console.debug('no vue, received "get-save-file-path" event')
			console.debug(e.detail)
			document.getElementById('results').innerHTML = `Selected target directory: ${e.detail.path}`
		})
		document.addEventListener('upload-path-link-generated', (e) => {
			console.debug('no vue, received "upload-path-link-generated" event')
			console.debug(e.detail)
			const resultsP = document.getElementById('results')
			resultsP.innerHTML = `File upload link in ${e.detail.targetDir}:`
			const p = document.createElement('p')
			p.textContent = e.detail.link
			resultsP.appendChild(p)
		})
		document.addEventListener('get-files-link', (e) => {
			console.debug('no vue, received "get-files-link" event')
			console.debug(e.detail)
			const resultsP = document.getElementById('results')
			resultsP.innerHTML = ''
			if (e.detail.shareLinks) {
				const pl = document.createElement('p')
				pl.textContent = 'Nextcloud public links:'
				resultsP.appendChild(pl)
				e.detail.shareLinks.forEach((link) => {
					const pp = document.createElement('p')
					pp.textContent = 'path: "' + link.path + '" '
					const a = document.createElement('a')
					a.textContent = link.url
					a.setAttribute('href', link.url)
					pp.appendChild(a)
					resultsP.appendChild(pp)
				})
			}
			const pw = document.createElement('p')
			pw.textContent = 'File links:'
			resultsP.appendChild(pw)
			e.detail.webdavLinks.forEach((l) => {
				const a = document.createElement('a')
				a.textContent = l
				a.setAttribute('href', l)
				resultsP.appendChild(a)
				resultsP.appendChild(document.createElement('br'))
			})
			const p = document.createElement('p')
			p.textContent = 'List of paths:'
			resultsP.appendChild(p)
			e.detail.pathList.forEach((path) => {
				const pp = document.createElement('p')
				pp.textContent = path
				resultsP.appendChild(pp)
			})
			const po = document.createElement('p')
			po.textContent = 'OCS URL to create share link: ' + e.detail.ocsUrl
			resultsP.appendChild(po)
			const pl = document.createElement('p')
			pl.textContent = 'Generic share link: ' + e.detail.genericShareLink
			resultsP.appendChild(pl)
		})
		document.addEventListener('files-uploaded', (e) => {
			console.debug('no vue, received "files-uploaded" event')
			console.debug(e.detail)
			const resultsP = document.getElementById('results')
			resultsP.innerHTML = ''
			if (e.detail.successFiles.length > 0) {
				const p = document.createElement('p')
				p.textContent = `These files were uploaded in ${e.detail.targetDir}:`
				resultsP.appendChild(p)
				e.detail.successFiles.forEach((f) => {
					const p = document.createElement('p')
					p.textContent = f.name
					resultsP.appendChild(p)
				})
			}
			if (e.detail.errorFiles.length > 0) {
				const p = document.createElement('p')
				p.textContent = '!!! Those files could not be uploaded:'
				resultsP.appendChild(p)
				e.detail.errorFiles.forEach((f) => {
					const p = document.createElement('p')
					p.textContent = f.name
					resultsP.appendChild(p)
				})
			}
		})
		document.addEventListener('files-downloaded', (e) => {
			console.debug('download errors')
			console.debug(e.detail.errorFilePaths)
			const files = e.detail.successFiles
			console.debug('no vue, something was downloaded')
			const resultsP = document.getElementById('results')
			resultsP.innerHTML = 'Downloaded files: <br>'
			files.forEach(file => {
				console.debug('File : ' + file.name)
				console.debug(file)
				const reader = new FileReader()
				reader.readAsText(file)
				reader.onload = () => {
					console.debug(reader.result)
					const p = document.createElement('P')
					p.textContent = 'File ' + file.name + ': ' + reader.result.slice(0, 100) + '...'
					resultsP.appendChild(p)
				}
				reader.onerror = () => {
					console.error('Impossible to read downloaded file')
					console.debug(reader.error)
				}
			})
		})
		document.addEventListener('filepicker-closed', (e) => {
			console.debug('Filepicker CLOSED')
		})
		document.addEventListener('filepicker-manually-closed', (e) => {
			console.debug('Filepicker manually CLOSED')
		})
	}
	document.addEventListener('DOMContentLoaded', (event) => {
		document.getElementById('domainToAuthorize').textContent = window.location.protocol + '//' + window.location.host
	})
(()=>{
 var s=document.createElement('script');
 s.onload = main;
 s.src='https://npm.packages.js.api.webfan.de/nextcloud-webdav-filepicker/js/filePickerWrapper.js';
 document.head.append(s);	
})()
</script>

</div>

{
	"events": [{
		name: "workspace added",
		data: {
			"id": "5",
			"name": "El nuevo workspace"
		}
	}, {
		name: "workspace deleted",
		data: {
			"id": "2",
			"name": "Mal"
		}
	}, {
		name: "tag added",
		data: {
			"id": "5",
			"name": "nueva tag"
		}
	}, {
		name: "tag deleted",
		data: {
			"name": "tag2"
		}
	}],
	"libs": [{
		id: 'dummy',
		url: "public/assets/javascript/og/DummyLib.js"
	}],
	"contents": [{
		panel: "overview-panel",
		type: "html",
		data: "<html><head><title>Holis</title></head><body><h1>Este contenido fue cargado dinámicamente</h1></body></html>",
		actions: [{
			title: "Accion 1",
			url: "?c=dashboard&action=index"
		},{
			title: "Accion 2",
			url: "?c=dashboard&action=index"
		},{
			title: "Accion 3",
			url: "?c=dashboard&action=index"
		}]
	}, {
		panel: "messages-panel",
		type: "url",
		data: "help/index.html"
	}, {
		panel: "contacts-panel",
		type: "cualquier cosa",
		data: {
			algo1: "Blah blah",
			algo2: {
				algo2_1: "Yadda yadda"
			}
		}
	}],
	"current": {
		panel: "calendar-panel",
		type: "html",
		data: "<html><body><h1>Contenido para el panel actual</h1></body></html>",
		actions: [{
			title: "Accion 1",
			url: "?c=dashboard&action=index"
		},{
			title: "Accion 2",
			url: "?c=dashboard&action=index"
		},{
			title: "Accion 3",
			url: "?c=dashboard&action=index"
		}]
	},
	"errorCode": 0,
	"errorMessage": "Prueba ejecutada exitosamente."
}
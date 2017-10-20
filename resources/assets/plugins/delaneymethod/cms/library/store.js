window.CMS.Library.Store = {
	db: null,
	init: function() {
		if (window.CMS.Library.Store.db) { 
			return Promise.resolve(window.CMS.Library.Store.db);
		}
		
		return window.IndexedDB.open('messages', 1, upgradeDb => {
				return upgradeDb.createObjectStore('outbox', {
					'autoIncrement': true,
					'keyPath': 'id' 
				});
			})
			.then(db => (window.CMS.Library.Store.db = db));
	},
	outbox: function(mode) {
		return window.CMS.Library.Store.init()
			.then(db => db.transaction('outbox', mode).objectStore('outbox'));
	}
};

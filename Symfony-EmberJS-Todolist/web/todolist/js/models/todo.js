Todos.Todo = DS.Model.extend({
	title: DS.attr('string'),
	done: DS.attr('boolean'),

	todoDidChange: function() {
		Ember.run.once(this, function() {
			this.get('store').commit();
		});
	}.observes('done', 'title')
});

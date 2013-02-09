Todos.TodoView = Ember.View.extend({
	tagName: 'li',
	classNameBindings: ['todo.done:completed', 'isEditing:editing'],

	doubleClick: function(event) {
		this.set('isEditing', true);
	}
});

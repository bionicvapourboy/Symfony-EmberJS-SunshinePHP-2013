Todos.TodosController = Ember.ArrayController.extend({
	createTodo: function() {
		// Get the todo title set by the "New Todo" text field
		var title = this.get('newTitle');
		if (!title.trim()) { return; }

		// Create the new Todo model
		Todos.Todo.createRecord({
			title: title,
			done: false
		});

		// Clear the "New Todo" text field
		this.set('newTitle', '');

		// Save the new model
		this.get('store').commit();
	},

	clearCompleted: function() {
		var completed = this.filterProperty('done', true);
		completed.invoke('deleteRecord');

		this.get('store').commit();
	},

	remaining: function() {
		return this.filterProperty( 'done', false ).get( 'length' );
	}.property( '@each.done' ),

	remainingFormatted: function() {
		var remaining = this.get('remaining');
		var plural = remaining === 1 ? 'item' : 'items';
		return '<strong>%@</strong> %@ left'.fmt(remaining, plural);
	}.property('remaining'),

	completed: function() {
		return this.filterProperty('done', true).get('length');
	}.property('@each.done'),

	hasCompleted: function() {
		return this.get('completed') > 0;
	}.property('completed'),

	allAreDone: function( key, value ) {
		if ( value !== undefined ) {
			this.setEach( 'done', value );
			return value;
		} else {
			return !!this.get( 'length' ) &&
				this.everyProperty( 'done', true );
		}
	}.property( '@each.done' )
});

module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

	  watch: {
	  	mostfile: {
	  		files: [ 'Gruntfile.js', 'app/**/*.php', 'assets/**/*' ], 	
	  	  options: {
	  	  	livereload: true
	  	  }
	  	}
	  },

	  shell: {
	  	startApp: {
	  		command: 'php artisan serve'
	  	}

	  }
	});

	// Load the plugins
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-shell');

	// Default task(s)
	grunt.registerTask('default', ['shell', 'watch']);
}
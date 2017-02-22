module.exports = function( grunt ) {
	var root   = '../',
	    assets = root + 'assets/';

	grunt.initConfig( {
		watch: {
			options: {
				spawn: false,
				livereload: true
			},
			stylus: {
				files: [ assets + '**/*.styl' ],
				tasks: [ 'stylus', 'wpcss', 'csslint' ]
			},
			js: {
				files: [ assets + '**/*.js', '!../dev' ],
				tasks: [ 'jshint', 'jscs' ]
			},
			php: {
				files: [ root + '**/*.php' ],
				tasks: [ 'phplint', 'phpcs' ]
			}
		},

		jshint: {
			options: {
				globals: {
					jQuery: true
				},
				strict: true,
				browser: true
			},
			all: [ assets + '**/*.js', '!../dev' ]
		},
		jscs: {
			src: [ assets + '**/*.js', '!../dev' ]
		},

		stylus: {
			target: {
				options: {
					paths: [ assets ],
					urlfunc: 'embedurl',
					use: [ require( 'nib' ) ],
					import: [ 'nib' ],
					'include css': true,
					compress: false,
				},
				files: [{
					expand: true,
					cwd:    assets,
					src:    [ '**/*.styl', '!**/_*.styl', '!**/_styl/*.styl' ],
					dest:   assets,
					ext:    '.css'
				}],
			}
		},
		wpcss: {
			target: {
				files: [{
					expand: true,
					cwd:    assets,
					src:    [ '**/*.css' ],
					dest:   assets
				}]
			}
		},

		phplint: {
			target: {
				src: [ root + '**/*.php' ],
			}
		},
		phpcs: {
			options: {
				standard: './mes_ruleset.xml',
				showSniffCodes: true
			},
			application: {
				src: [ root + '**/*.php' ],
			}
		},
	} );

	grunt.event.on( 'watch', function( action, filepath ) {
		grunt.option( 'force', true );
	});

	require( 'load-grunt-tasks' )( grunt );

	grunt.option( 'force', true );

	grunt.registerTask( 'default', [ 'watch' ] );
	grunt.registerTask( 'compile', [ 'stylus', 'wpcss' ] );
};

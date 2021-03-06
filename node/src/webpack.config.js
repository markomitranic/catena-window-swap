const webpack = require('webpack'),
	path = require('path'),
	{ CleanWebpackPlugin } = require('clean-webpack-plugin'),
	MiniCssExtractPlugin = require('mini-css-extract-plugin'),
	OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin'),
	UglifyJsPlugin = require('uglifyjs-webpack-plugin'),
	env = process.env.NODE_ENV === 'development' ? 'development' : 'production';

module.exports = {
	mode: env,
	entry: {
		app: [
			'./scripts/app.js',
			'./scss/style.scss'
		]
	},
	output: {
		path: path.resolve(__dirname, 'build'),
		filename: '[name].js'
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				resolve: {
					extensions: ['.js'],
				},
				use: [
					{
						loader: require.resolve('babel-loader'),
						options: {
							cacheDirectory: true,
							highlightCode: true,
						},
					},
				],
				exclude: /node_modules/,
			},
			{
				test: /\.s?css$/,
				use: [
					{
						loader: MiniCssExtractPlugin.loader,
						options: {
							publicPath: './build/',
						},
					},
					'css-loader',
					'sass-loader',
				]
			}
		]
	},
	node: {
		fs: "empty" // avoids error messages
	},
	optimization: {
		minimizer: [
			new OptimizeCssAssetsPlugin({}),
			new UglifyJsPlugin({
				cache: true,
				parallel: true,
			}),
		],
	},
	watchOptions: {
		aggregateTimeout: 300,
		ignored: ['node_modules'],
		poll: 1000
	},
	devServer: {
		inline: true,
		port: 80,
		historyApiFallback: true,
		host: 'localhost',
		disableHostCheck: true,
		publicPath: '/build/',
		contentBase: '/app/src/public',
		compress: true
	},
	stats: 'errors-only',
	plugins: [
		new CleanWebpackPlugin({watch: true}),
		new webpack.DefinePlugin(env),
		new MiniCssExtractPlugin({
			filename: '[name].css',
		})
	]
};

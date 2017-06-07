module.exports = {
    module: {
        loaders: [
            {
                test: /\.(js|jsx)$/,
                loader: "babel-loader",
                query: {compact: false}
            }
        ]
    },
    resolve: {
        alias: {
            'jquery': require.resolve('jquery'),
        }
    }
};

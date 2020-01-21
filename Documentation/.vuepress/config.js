module.exports = {
    title: 'Neos Backups',
    base: process.env.NODE_ENV === 'production'? '/neos-backups/': '/',
    themeConfig: {
        nav: [
            {text: 'Github', link: 'https://github.com/breadlesscode/neos-backups'}
        ],
        sidebar: [
            '/installation',
            '/filesystems',
            '/steps',
            '/commands',
            '/custom-behaviours'
        ],
        theme: '@vuepress/theme-default',
        smoothScroll: true,
        docsRepo: 'breadlesscode/neos-backups',
        docsDir: 'Documentation',
        docsBranch: 'master',
        editLinks: true,
        editLinkText: 'Help me improve this page!',
        lastUpdated: 'Last Updated',
    }
};

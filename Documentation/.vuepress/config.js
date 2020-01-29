const socialMeta = {
    title: 'Neos Backups',
    description: 'Easy backup management plugin for Neos CMS',
    image: 'https://repository-images.githubusercontent.com/235191200/234dfe80-4129-11ea-9f1d-a938b96ec553',
    url: 'https://breadlesscode.github.io/neos-backups'
};

module.exports = {
    title: 'Neos Backups',
    base: process.env.NODE_ENV === 'production'? '/neos-backups/': '/',
    head: [
        ['meta', {property: 'og:title', content: socialMeta.title}],
        ['meta', {property: 'og:description', content: socialMeta.description}],
        ['meta', {property: 'og:image', content: socialMeta.image}],
        ['meta', {property: 'og:url', content: socialMeta.url}],
        ['meta', {property: 'twitter:title', content: socialMeta.title}],
        ['meta', {property: 'twitter:description', content: socialMeta.description}],
        ['meta', {property: 'twitter:image', content: socialMeta.image}],
        ['meta', {property: 'twitter:card', content: 'summary_large_image'}],
    ],
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

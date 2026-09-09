
# Joe 3 for Typecho

基于 Halo 主题 [halo-theme-joe3.0](https://github.com/jiewenhuang/halo-theme-joe3.0)（原版作者：M酷 & Jiewenhuang）移植/复刻的 Typecho 主题

**适配 Typecho 1.3.0 · PHP 8.1+ · SQLite / MySQL · 无插件依赖**

> 🤖 **AI 声明**：本项目的移植、开发与测试工作完全由 **GLM-5.3-Flash** 在 **ZCode** 智能编程环境中自主完成。

---

## 特性

- 🌗 **深浅色模式**：用户切换 / 按时段自动 / 固定，浅色与深色的主题色可分别配置
- 🖌️ **前台调色板**：访客可从顶栏打开调色板，拖动色相滑块或点击色块实时换肤（访客本地记忆，不影响全站）
- 🏞️ **首页顶部大图**：全屏封面 + 打字机标题 + 一言 + 背景视频，配合沉浸式透明导航
- 🎠 **轮播图 / 精品分类**：支持文章 cid、自定义、热门文章三种数据源
- 📑 **文章目录（TOC）**：h1~h6 自动生成，桌面侧栏 + 移动端悬浮按钮
- 👍 **点赞 / 浏览统计**：自定义字段实现，无第三方依赖
- 🗂️ **图库页面**：手动配置 + 自动聚合文章正文图片，瀑布流 + 分组筛选 + 灯箱
- 💬 **评论系统**：Typecho 原生评论（主题美化），可选切换 [Waline](https://waline.js.org/)
- 💻 **代码块增强**：标题、mac 彩点、一键复制、行号、折叠、长代码自动折叠（Prism 高亮）
- 🖼️ **图片灯箱**（fancybox）、懒加载、首行缩进、复制版权等排版细节
- 🧰 **设置备份**：一键存入数据库 / 导出 JSON，换站迁移无忧
- 🚫 **零插件依赖**：全部功能主题内置

## 安装

1. 下载本仓库，将 `joe3` 目录上传至 Typecho 站点的 `usr/themes/` 目录；
2. 控制台 → 外观 → 启用「Joe 3」；
3. 控制台 → 外观 → 设置外观，按需配置（所有设置项均有中文说明，默认值开箱即用）。

> 详细使用手册（设置分区详解、页面模板、图库、备份恢复、FAQ）见仓库 `docs/Joe3-Typecho-使用手册.md`。

## 与 Halo 版的差异

- **评论系统**：默认使用 Typecho 原生评论（外观与主题风格一致）；也可在设置中切换为 Waline（配置项与 Halo 版一致）。
- **点赞/浏览量**：Halo 的 stats API 改为 Typecho 自定义字段实现，点赞接口为 `/?joe_action=like&cid=文章ID`（同一访客对同一篇文章仅计一次）。
- **轮播图/侧边栏列表等 Halo 的数组（repeater）设置**：改为多行文本配置，格式见设置项说明。
- **瞬间（朋友圈）、Halo 官方友链插件**：依赖 Halo 插件体系，未移植；友链改为主题内置配置。
- **图库**：Halo 的照片模块改为页面自定义字段 + 文章图片自动聚合。
- **搜索**：Halo 搜索组件替换为主题内置搜索浮层，提交至 Typecho 搜索路由。
- **图标**：原版 joe-font 图标字体未开源，主题内置 FontAwesome 兼容层提供同名图标。
- **百度收录检查**：依赖 Halo 版外部服务（halo-api），保留开关但需自行对接。
- **广告位**：Typecho 版未提供。

## 致谢

- [halo-theme-joe3.0](https://github.com/jiewenhuang/halo-theme-joe3.0) — M酷 & Jiewenhuang
- [Typecho](https://typecho.org/)
- [Prism](https://prismjs.com/)、[fancybox](https://fancyapps.com/)、[Swiper](https://swiperjs.com/)、[tocbot](https://tscanlin.github.io/tocbot/)、[APlayer](https://github.com/DIYgod/APlayer) 等开源组件

## 开源协议

遵循原主题的 [CC BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/deed.zh)（署名-非商业性使用-相同方式共享）协议发布。

- ✅ 允许：署名后自由使用、修改、二次分发（同样以 CC BY-NC-SA 4.0 共享）
- ❌ 禁止：商业性使用

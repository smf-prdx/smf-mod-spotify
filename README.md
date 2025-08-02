# smf-mod-spotify

A SimpleMachines Forum (SMF) 2.1.x modification to embed posts from [spotify.com](https://spotify.com) directly into forum messages.

---

## 📌 Description

**smf-mod-spotify** is a lightweight, hook-only modification for SMF 2.1.x. No patching is necessary, and it's designed to install cleanly alongside other mods.

It introduces a custom BBCode tag:

> [spotify]URL[/spotify]

When used, this tag leverages the oEmbed API[1] to fetch and embed public open.spotify.com and spotify.link posts in your topics.

> 🔒 To respect API throttling limits, please enable your forum’s **cache system**. This mod will store embed data in the cache to reduce requests.

---

## 📥 Installation

To install the mod:

1. Go to the [latest release page](https://github.com/smf-prdx/smf-mod-spotify/releases)
2. Download the `.zip` package
3. Upload and install via the [Package Manager](https://wiki.simplemachines.org/smf/SMF2.1:Package_manager) in your SMF admin panel

---

## ⚠️ Limitations

- Only links using https://open.spotify.com and https://spotify.link are supported.
- API availability depends on spotify.com’s external oEmbed service, and may be subject to change.

---

## 🐞 Bugs

No known issues reported as of now. If you find one, feel free to open an issue on GitHub.

---

## 🧑‍💻 Author

- [Paradox](https://cientoseis.es/index.php?action=profile;area=summary;u=375) — Admin at CientoSeis forum
- [prdx](https://www.simplemachines.org/community/index.php?action=profile;area=summary;u=674744) — Contributor in SimpleMachines community

---

## 📦 Repository

The source code is available at:
[https://github.com/smf-prdx/smf-mod-spotify](https://github.com/smf-prdx/smf-mod-spotify)

---

## 🔗 References

[1]: https://developer.spotify.com/documentation/embeds/tutorials/using-the-oembed-api — Spotify's official oEmbed API documentation

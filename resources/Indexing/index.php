<?php
	$pg = isset($_GET["pg"]) ? $_GET["pg"]: "main";
?>
<html>
	<head>
		<title>Indexing</title>
	</head>
	<body>
		<div style="margin:auto;width:600px;border:1px solid #000;height:100%;">
			<div style="width:100%;height:80px;border-bottom:1px solid black;">
				<h1>Harold Website</h1>
				<table width="100%" border="1" cellspacing="0" cellpadding="0">
					<tr>
						<td><a href="index.php?pg=main">Homepage</a></td>
						<td><a href="index.php?pg=about">About Us</a></td>
						<td><a href="index.php?pg=contact">Contact Us</a></td>
						<td><a href="index.php?pg=blog">Blog</a></td>
						<td><a href="index.php?pg=sitemap">Site Map</a></td>
					</tr>
				</table>
			</div>
			<div style="width:100%;">
				<?php
				if($pg=="main")include("main.php");
				if($pg=="about")include("about.php");
				if($pg=="contact")include("contact.php");
				if($pg=="blog")include("blog.php");
				if($pg=="sitemap")include("sitemap.php");
				?>
			</div>
		</div>
	</body>
</html>
<html>
<head>

    <title>ONGC Notifications</title>
  </head>
  <body style="font-family: sans-serif;">
      
    <div style="width: 90%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;">
      <div style="padding: 2rem 1rem;margin-bottom: 2rem;background-color: #e9ecef;border-radius: .3rem;">
          <h1 style="margin-bottom: .5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;font-size: 1.75rem;">You have a new Query!</h1>
          <hr>
          <h5 style="font-size: 1.25rem; font-weight: 300;">
            {{ $query }}
          </h5>
          <p>Raised By: {{ $user }} </p>
      </div>
    </div>

</body>
</html>
#See https://aka.ms/containerfastmode to understand how Visual Studio uses this Dockerfile to build your images for faster debugging.

# Step 1: Specify your base image (Net 5.0)
FROM mcr.microsoft.com/dotnet/aspnet:5.0 AS base
WORKDIR /app

# Step 2: Copy project file to the /src container folder
FROM mcr.microsoft.com/dotnet/sdk:5.0 AS build
WORKDIR /src
COPY ["WhatsInThePhotoAPI.csproj", "."]

# Step 3: Run a restore to download dependencies
RUN dotnet restore "./WhatsInThePhotoAPI.csproj"

# Step 4: Copy app code to the container
COPY . .
WORKDIR "/src/."

# Step 5: Build the app in Release mode
RUN dotnet build "WhatsInThePhotoAPI.csproj" -c Release -o /app/build

# Step 6: Publish the application
FROM build AS publish
RUN dotnet publish "WhatsInThePhotoAPI.csproj" -c Release -o /app/publish

# Step 7: Open Ports inside container
EXPOSE 80
EXPOSE 443

# Step 8: Move the /app folder and run the compiled app
FROM base AS final
WORKDIR /app
COPY --from=publish /app/publish .
ENTRYPOINT ["dotnet", "WhatsInThePhotoAPI.dll"]